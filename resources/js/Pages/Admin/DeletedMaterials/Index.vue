<template>
    <head>
        <title>Админ панель | Жойылған материалдар</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Жойылған материалдар тізімі</h1>
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
                            Жойылған материалдар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link
                    class="btn btn-danger"
                    :href="route('admin.deletedMaterials.index')"
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
                                        <th>Автор</th>
                                        <th>Тақырыбы</th>
                                        <th>Инфо</th>
                                        <th>Жою себебі</th>
                                        <th>Статус</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.author"
                                                class="form-control"
                                                placeholder="Автор"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.title"
                                                class="form-control"
                                                placeholder="Тақырыбы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                @change.prevent="search()"
                                                v-model="filter.zhanr"
                                                placeholder="Пән"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="materialSubject.name"
                                                    v-for="materialSubject in materialSubjects"
                                                    :key="materialSubject.name"
                                                >
                                                    {{ materialSubject.name }}
                                                </option>
                                            </select>
                                            <select
                                                class="form-control mt-2 mb-2"
                                                @change.prevent="search()"
                                                v-model="filter.zhanr2"
                                                placeholder="Бағыты"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="materialDirection.name"
                                                    v-for="materialDirection in materialDirections"
                                                    :key="materialDirection.name"
                                                >
                                                    {{ materialDirection.name }}
                                                </option>
                                            </select>

                                            <select
                                                class="form-control"
                                                @change.prevent="search()"
                                                v-model="filter.zhanr3"
                                                placeholder="Сынып"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="materialClass.name"
                                                    v-for="materialClass in materialClasses"
                                                    :key="materialClass.name"
                                                >
                                                    {{ materialClass.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td>
                                            <select
                                                class="form-control"
                                                @change.prevent="search()"
                                                v-model="filter.deleteorder"
                                                placeholder="Статус"
                                            >
                                                <option :value="'all'">
                                                    Барлығы
                                                </option>
                                                <option value="1">
                                                    Қаралмаған
                                                </option>
                                                <option value="2">
                                                    Қабылданды
                                                </option>
                                                <option value="3">
                                                    Қабылданбады
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-success d-flex align-items-center"
                                                @click.prevent="search()"
                                            >
                                                <i
                                                    class="fas fa-search mr-2"
                                                ></i>
                                                Іздеу
                                            </button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="odd"
                                        v-for="(
                                            material, index
                                        ) in deletedMaterials.data"
                                        :key="'material' + material.id"
                                    >
                                        <td>
                                            {{
                                                deletedMaterials.from
                                                    ? deletedMaterials.from +
                                                      index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>
                                            {{ material.author }}
                                        </td>
                                        <td>
                                            {{ material.title }}
                                        </td>
                                        <td>
                                            <b>Пән:</b>
                                            {{ material.zhanr }}
                                            <br />
                                            <b>Бағыт:</b>
                                            {{ material.zhanr2 }}
                                            <br />
                                            <b>Сынып:</b>
                                            {{ material.zhanr3 }}
                                        </td>
                                        <td>
                                            {{
                                                material.deleteordertext == '' ?
                                                "Толтырылмаған" : material.deleteordertext
                                            }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-success"
                                                :class="{
                                                    'badge-success':
                                                        material.deleteorder ==
                                                        2,
                                                    'badge-danger':
                                                        material.deleteorder ==
                                                        3,
                                                    'badge-warning':
                                                        material.deleteorder ==
                                                        1,
                                                }"
                                            >
                                                {{
                                                    getStatusText(
                                                        material.deleteorder
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.deletedMaterials.edit',
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
                    <Pagination :links="deletedMaterials.links" />
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
        "deletedMaterials",
        "materialSubjects",
        "materialDirections",
        "materialClasses",
    ],
    data() {
        return {
            filter: {
                title: route().params.title ? route().params.title : null,
                zhanr: route().params.zhanr
                    ? route().params.zhanr
                    : null,
                zhanr2: route().params.zhanr2
                    ? route().params.zhanr2
                    : null,
                zhanr3: route().params.zhanr3
                    ? route().params.zhanr3
                    : null,
                author: route().params.author
                    ? route().params.author
                    : null,
                deleteorder: route().params.deleteorder ? route().params.deleteorder : "all",
            },
            loading: 0,
        };
    },
    methods: {
        getStatusText(status) {
            if (!status) {
                return "Жоюға жіберілмеген";
            }

            if (status == 1) {
                return "Қаралмаған";
            }
            if (status == 2) {
                return "Қабылданды";
            }
            if (status == 3) {
                return "Қабылданбады";
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
                    this.$inertia.delete(
                        route("admin.deletedMaterials.destroy", id)
                    );
                }
            });
        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            console.log("params", params);
            this.$inertia.get(route("admin.deletedMaterials.index"), params);
        },
    },
};
</script>
