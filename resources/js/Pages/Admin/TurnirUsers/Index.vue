<template>

    <head>
        <title>Админ панель | Турнир қатысушылары</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Турнир қатысушылар тізімі</h1>
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
                            Турнир қатысушылар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-danger" :href="route('admin.turnirUser.index')">
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
                            <table class="table table-hover table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr role="row">
                                        <th>№</th>
                                        <th>User_ID</th>
                                        <th>ФИО</th>
                                        <th>Турнир</th>
                                        <th>Код нөмірі</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input v-model="filter.user_id" class="form-control" placeholder="ID" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.fio_user" class="form-control" placeholder="Имя" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.turnir_name" class="form-control" placeholder="Имя" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.order_id" class="form-control" placeholder="Имя" @keyup.enter="search" />
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(user, index) in users.data" :key="'user' + user.id">
                                        <td>
                                            {{
                                                users.from
                                                    ? users.from + index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>
                                            <Link :href="
                                                    route(
                                                        'admin.turnirUser.edit',
                                                        user.user_id
                                                    )
                                                ">
                                                {{ user.user_id }}
                                            </Link>
                                        </td>
                                        <td>{{ user.fio_user }}</td>
                                        <td>{{ user.turnir_name }}</td>
                                        <td>{{ user.order_id }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="
                                                        route(
                                                            'admin.turnirUser.edit',
                                                            user
                                                        )
                                                    " class="btn btn-primary" title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>


                                                <button @click.prevent="deleteData(user.id)" class="btn btn-danger" title="Жою">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="users.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
    import AdminLayout from "../../../Layouts/AdminLayout.vue";
    import {
        Link,
        Head
    } from "@inertiajs/inertia-vue3";
    import Pagination from "../../../Components/Pagination.vue";
    export default {
        components: {
            AdminLayout,
            Link,
            Pagination,
            Head
        },
        props: ["users"],
        data() {
            return {
                filter: {
                    user_id: route().params.user_id ?
                        route().params.user_id : null,
                    fio_user: route().params.fio_user ?
                        route().params.fio_user : null,
                    turnir_name: route().params.turnir_name ?
                        route().params.turnir_name : null,
                    order_id: route().params.order_id ?
                        route().params.order_id : null,
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
                        this.$inertia.delete(route("admin.turnirUser.destroy", id));
                    }
                });
            },
            search() {
                this.loading = 1
                const params = this.clearParams(this.filter);
                this.$inertia.get(route("admin.turnirUser.index"), params);
            },
            statusId(id){
                switch(id){
                    case 1: return 'Мұғалім'
                    case 2: return 'Оқушы'
                    case 3: return 'Басқа'
                }
            }
        },
    };

</script>
