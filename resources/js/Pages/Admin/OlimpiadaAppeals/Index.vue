<template>
    <head>
        <title>Админ панель | Тест апеляция</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Тест апеляция тізімі</h1>
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
                            Тест апеляция тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons">
                <Link
                    class="btn btn-danger"
                    :href="route('admin.olimpiadaAppeals.index')"
                >
                    <i class="fa fa-trash"></i> Фильтрді тазалау
                </Link>
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
                                        <th>Аты-жөні</th>
                                        <th>Сұрақ</th>
                                        <th>Қате түрі</th>
                                        <th>Комментария</th>
                                        <th>Статус</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td></td>
                                        <td></td>
<!--
                                        <td>
                                            <input
                                                v-model="filter.username"
                                                class="form-control"
                                                placeholder="Аты-жөні"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.surak"
                                                class="form-control"
                                                placeholder="Сұрақ"
                                                @keyup.enter="search"
                                            />
                                        </td>
-->
                                        <td>
                                            <select
                                                v-model="filter.variable"
                                                class="form-control"
                                                @change.prevent="search"
                                            >
                                            <option :value="null" selected> Барлығы</option>
                                            <option
                                            :value="appeal_type_item.name"
                                             v-for=" (appeal_type_item, index) in appeal_types" :key="'appeal_types' + index ">
                                                {{ appeal_type_item.name }}
                                            </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.text"
                                                class="form-control"
                                                placeholder="Комментария"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                @change.prevent="search()"
                                                v-model="filter.is_checked"
                                                placeholder="Статус"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option value="0">
                                                    Қаралмаған
                                                </option>
                                                <option value="1">
                                                    Тексерілді
                                                </option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="odd"
                                        v-for="(appeal, index) in appeals.data"
                                        :key="'appeal' + appeal.id"
                                    >
                                        <td>
                                         {{
                                                appeals.from
                                                    ? appeals.from + index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>{{ appeal.user?.fio }}</td>
                                        <td>{{ appeal.surak.surak }}</td>
                                        <td>
                                            {{ appeal.variable }}
                                        </td>
                                        <td>{{ appeal.text }}</td>
                                        <td>
                                            <span
                                                class="badge badge-success"
                                                :class="{
                                                    'badge-success':
                                                        appeal.is_checked ==
                                                        1,
                                                    'badge-warning':
                                                        appeal.is_checked ==
                                                        0,
                                                }"
                                            >
                                                {{
                                                    getStatusText(
                                                        appeal.is_checked
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                               <Link
                                                    :href="
                                                        route(
                                                            'admin.olimpiadaAppeals.edit',
                                                            appeal.id
                                                        )
                                                    "
                                                    class="btn btn-primary"
                                                    title="Тест сұрағын өзгерту"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>
                                                <button
                                                    @click.prevent="
                                                        deleteData(appeal.id)
                                                    "
                                                    class="btn btn-danger"
                                                    title="Жою"
                                                >
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <Pagination :links="appeals.links" />

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
        Head,
        Pagination
    },
    props: ["appeals"],
    data() {
        return {
            filter: {
                username: route().params.username ?? null,
                surak: route().params.surak ?? null,
                variable: route().params.variable ?? null,
                text: route().params.text ?? null,
                is_checked: route().params.is_checked ?? null,
            },
            appeal_types: [
                {
                    name: 'Сұрақта грамматикалық қате бар'
                },
                {
                    name: 'Жауабы қате'
                },
                {
                    name: 'Сұрақтың мазмұнында қателік бар'
                },
                {
                    name: 'Жауап нұсқалары бірдей'
                },
                {
                    name: 'Басқа қателер'
                },
            ]
        };
    },
    mounted() {
        console.log(this.appeals)
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
                    this.$inertia.delete(
                        route("admin.olimpiadaAppeals.destroy", id)
                    );
                }
            });
        },
        getStatusText(status) {
            if (status == 0) {
                return "Қаралмаған";
            }
            if (status == 1) {
                return "Тексерілген";
            }
            return "Анықталмаған";
        },
        search() {
            const params = this.clearParams(this.filter);
            this.$inertia.get(route("admin.olimpiadaAppeals.index"), params);
        },
    },
};
</script>
