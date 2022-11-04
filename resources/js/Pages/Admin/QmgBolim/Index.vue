<template>
       <head>
        <title>Админ панель | ҚМЖ Бөлімдер</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ҚМЖ Бөлімдер тізімі</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            ҚМЖ Бөлімдер тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
               <Link class="btn btn-primary mr-2" :href="route('admin.qmgBolim.create')">
                    <i class="fa fa-plus"></i> Қосу
                </Link>

                <Link
                    class="btn btn-danger"
                    :href="route('admin.qmgBolim.index')"
                >
                    <i class="fa fa-trash"></i> Фильтрді тазалау
                </Link>
                <div v-if="loading" class="spinner-border text-primary mx-3" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table
                                class="table table-hover table-bordered table-striped dataTable dtr-inline"
                            >
                                <thead>
                                    <tr role="row">
                                        <th>№</th>
                                        <th>Тақырыбы</th>
                                        <th>Мерзімі</th>
                                        <th>Сыныбы</th>
                                        <th>Пән</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.title"
                                                class="form-control"
                                                placeholder="Тақырыбы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.date"
                                                class="form-control"
                                                placeholder="Мерзімі"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.synyp_text"
                                                class="form-control"
                                                placeholder="Мерзімі"
                                                @keyup.enter="search"
                                            />
                                        </td>


                                        <td>
                                            <select
                                                v-model="filter.sub_id"
                                                class="form-control"
                                                placeholder="Пәні"
                                                @change.prevent="search"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="subject.id"
                                                    :key="
                                                        'subject' +
                                                        subject.name
                                                    "
                                                    v-for="subject in subjects"
                                                >
                                                    {{ subject.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="odd"
                                        v-for="(
                                            bolim, index
                                        ) in bolimder.data"
                                        :key="'bolim' + bolim.id"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ bolim.title }}</td>
                                        <td>{{ bolim.date }}</td>
                                        <td>{{ bolim.synyp_text }}</td>
                                        <td>{{ bolim.subject.name }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
<!--
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.qmgBolim.comments',
                                                            { id: material.id }
                                                        )
                                                    "
                                                    class="btn btn-success"
                                                    title="Пікірлер"
                                                >
                                                    <i
                                                        class="fas fa-comment"
                                                    ></i>
                                                </Link>
-->
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.qmgBolim.edit',
                                                            bolim.id
                                                        )
                                                    "
                                                    class="btn btn-primary"
                                                    title="Изменить"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteData(bolim.id)
                                                    "
                                                    class="btn btn-danger"
                                                    title="Жою"
                                                >
                                                    <i
                                                        class="fas fa-times"
                                                    ></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="bolimder.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        Head,
    },
    props: [
        "bolimder",
        "subjects",
    ],
    data() {
        return {
            filter: {
                title: route().params.title ? route().params.title : null,
                date: route().params.date ? route().params.date : null,
                synyp_text: route().params.synyp_text ? route().params.synyp_text : null,
                sub_id: route().params.sub_id ? route().params.sub_id : null,
            },
            loading: 0,
        };
    },
    methods: {
        deleteData(id) {
              Swal.fire({
                title: "Жоюға сенімдісіз бе?",
                text: "Қайтып қалпына келмеуі мүмкін!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Иә, жоямын!",
                cancelButtonText: "Жоқ",
            }).then((result) => {
                if (result.isConfirmed) {
                this.$inertia.delete(route("admin.qmgBolim.destroy", id));
                }
            });

        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route("admin.qmgBolim.index"), params);
        },
    },
};
</script>
<style lang="scss">
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type="number"] {
    -moz-appearance: textfield;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    height: auto;
}
.file-upload {
    .file {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
    }

    .file-input label {
        width: 158px;
        height: 40px;
        border-radius: 5px;
        border-color: #ddd;
        background: #eee;
        box-shadow: 0 3px 4px rgb(0 0 0 / 40%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #555;
        cursor: pointer;
        transition: transform 0.2s ease-out;
    }
    input:hover + label,
    input:focus + label {
        transform: scale(1.02);
    }
}
/* Firefox */
</style>
