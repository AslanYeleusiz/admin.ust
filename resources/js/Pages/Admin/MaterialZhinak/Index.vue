<template>
       <head>
        <title>Админ панель | Материалдар жинақ</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Жинақ материалдар</h1>
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
                            Жинақ материалдар
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link
                    class="btn btn-danger"
                    :href="route('admin.materials.index')"
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
                                        <th>Қолданушы ID</th>
                                        <th>Материал атауы</th>
                                        <th>Аты - жөні</th>
                                        <th>Жинақ айы(сан)</th>
                                        <th>Жинақ жыл(сан)</th>
                                        <th>Статус</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.user_id"
                                                class="form-control"
                                                placeholder="Қолданушы ID"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.doc_name"
                                                class="form-control"
                                                placeholder="Материал атауы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.username"
                                                class="form-control"
                                                placeholder="Аты - жөні"
                                                @keyup.enter="search"
                                            />
                                        </td>


                                        <td>
                                            <select
                                                v-model="filter.zhmonth"
                                                class="form-control"
                                                placeholder="Жинақ айы"
                                                @change.prevent="search"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="month.id"
                                                    :key="
                                                        'month' +
                                                        month.id
                                                    "
                                                    v-for="month in months"
                                                >
                                                    {{ month.month }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select
                                                v-model="filter.zhyear"
                                                class="form-control"
                                                placeholder="Жинақ жылы"
                                                @change.prevent="search"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="n+2020"

                                                    v-for="n in (currentDate.getFullYear()-2020)"
                                                >
                                                    {{ n+2020 }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                @change.prevent="search()"
                                                v-model="filter.step"
                                                placeholder="Статус"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option value="1">
                                                    Қаралмаған
                                                </option>
                                                <option value="2">
                                                    Қате бар
                                                </option>
                                                <option value="3">
                                                    Тексерілген
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
                                            material, index
                                        ) in materials.data"
                                        :key="'material' + material.id"
                                    >
                                        <td>{{ index+1 }}</td>
                                        <td>{{ material.user.id }}</td>
                                        <td>{{ material.doc_name }}</td>
                                        <td>{{ material.username }}</td>
                                        <td>{{ months[material.zhmonth-1].month }}</td>
                                        <td>{{ material.zhyear }}</td>
                                        <td>
                                            <span
                                                class="badge badge-success"
                                                :class="{
                                                    'badge-success':
                                                        material.step ==
                                                        3,
                                                    'badge-danger':
                                                        material.step ==
                                                        2,
                                                    'badge-warning':
                                                        material.step ==
                                                        1,
                                                }"
                                            >
                                                {{
                                                    getStatusText(
                                                        material.step
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
<!--
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.materials.comments',
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
                                                            'admin.materialZhinak.edit',
                                                            material
                                                        )
                                                    "
                                                    class="btn btn-primary"
                                                    title="Изменить"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteData(material.id)
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
                    <Pagination :links="materials.links" />
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
        "materials",
        "months",
    ],
    data() {
        return {
            filter: {
                user_id: route().params.user_id ? route().params.user_id : null,
                doc_name: route().params.doc_name
                    ? route().params.doc_name
                    : null,
                username: route().params.username
                    ? route().params.username
                    : null,
                zhmonth: route().params.zhmonth
                    ? route().params.zhmonth
                    : null,
                zhyear: route().params.zhyear
                    ? route().params.zhyear
                    : null,
                step: route().params.step
                    ? route().params.step
                    : null,


            },
            loading: 0,
            currentDate: new Date,
        };
    },
    methods: {
        getStatusText(status) {
            if (!status) {
                return "Қате";
            }
            if (status == 1) {
                return "Қаралмаған";
            }
            if (status == 2) {
                return "Қате бар";
            }
            if (status == 3) {
                return "Тексерілген";
            }
            return "Анықталмаған";
        },
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
                this.$inertia.delete(route("admin.materialZhinak.destroy", id));
                }
            });
        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route("admin.materialZhinak.index"), params);
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
