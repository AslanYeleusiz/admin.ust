<template>
       <head>
        <title>Админ панель | Олимпиада бағыты | Нұсқалар</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Нұсқалар тізімі</h1>
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
                            Олимпиада бағыты тізімі
                        </li>
                        <li class="breadcrumb-item active">
                            Нұсқалар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link v-if="bagyt.o_katysushy_idd == 3" class="btn btn-primary mr-2" :href="route('admin.olimpiadaOption.create', bagyt_id)">
                    <i class="fa fa-plus"></i> Қосу
                </Link>
                <Link
                    class="btn btn-danger"
                    :href="route('admin.olimpiadaOption.index', bagyt_id)"
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
                                        <th>Нұсқа</th>
                                        <th>Сұрақтар саны</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.option"
                                                class="form-control"
                                                placeholder="Тақырыбы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="odd"
                                        v-for="(
                                            option, index
                                        ) in options.data"
                                        :key="'option' + option.id"
                                    >
                                        <td>
                                            {{
                                                options.from
                                                    ? options.from + index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>{{ option.o_tury }}</td>
                                        <td>{{ option.suraktar_count }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                               <Link
                                                    :href="
                                                        route(
                                                            'admin.olimpiadaSuraktar.index',
                                                            [bagyt_id, option.idd]
                                                        )
                                                    "
                                                    class="btn btn-success"
                                                    title="Сұрақтар"
                                                >
                                                    <i
                                                        class="fas fa-book-reader"
                                                    ></i>
                                                </Link>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.olimpiadaOption.edit',
                                                            {
                                                                bagyt: bagyt_id,
                                                                option: option.idd
                                                            }
                                                        )
                                                    "
                                                    class="btn btn-primary"
                                                    title="Изменить"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteData(option.idd)
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
                    <Pagination :links="options.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../../Components/Pagination.vue";
export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        Head,
    },
    props: [
        'bagyt', 'options',
    ],
    data() {
        return {
            filter: {
                option: route().params.option ? route().params.option : null,
            },
            bagyt_id: route().params.bagyt,
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
                this.$inertia.delete(route("admin.olimpiadaOption.destroy",[this.bagyt_id,id]));
                }
            });

        },
        getCategory(e){
            switch(e){
                case 1: return "Тәрбиешілерге"
                case 2: return "Ұстаздарға"
                case 3: return "Оқушыларға"
                case 4: return "Студенттерге"
            }
        },
        getStatusText(e){
            if(e) return "Белсенді"
            return "Белсенді емес"
        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route("admin.olimpiadaOption.index", this.bagyt_id), params);
        },
    },
};
</script>
