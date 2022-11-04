<template>

    <head>
        <title>Админ панель | Қолданушылар</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Қолданушылар тізімі</h1>
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
                            Қолданушылар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.users.create')">
                <i class="fa fa-plus"></i> Қосу
                </Link>

                <Link class="btn btn-danger" :href="route('admin.users.index')">
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
                                        <th>ID</th>
                                        <th>Аты</th>
                                        <th>Есімі</th>
                                        <th>Әкесінің аты</th>
                                        <th>Почта</th>
                                        <th>Телефон</th>
                                        <th>Пароль</th>
                                        <th>Рөлі</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input v-model="filter.id" class="form-control" placeholder="ID" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.username" class="form-control" placeholder="Имя" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.s_name" class="form-control" placeholder="Имя" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.l_name" class="form-control" placeholder="Имя" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.email" class="form-control" placeholder="Email" @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.phone" class="form-control" placeholder="Телефон" @keyup.enter="search" />
                                        </td>
                                        <td></td>
                                        <td></td>
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
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.username }}</td>
                                        <td>{{ user.s_name }}</td>
                                        <td>{{ user.l_name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.tel_num }}</td>
                                        <td>{{ user.real_password }}</td>
                                        <td>
                                            {{ statusId(user.user_status_id) }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="
                                                        route(
                                                            'admin.users.edit',
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
                    username: route().params.username ?
                        route().params.username : null,
                    s_name: route().params.s_name ?
                        route().params.s_name : null,
                    l_name: route().params.l_name ?
                        route().params.l_name : null,
                    id: route().params.id ? route().params.id : null,
                    email: route().params.email ? route().params.email : null,
                    phone: route().params.phone ? route().params.phone : null,
                    sex: route().params.sex ? route().params.sex : null,
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
                        this.$inertia.delete(route("admin.users.destroy", id));
                    }
                });
            },
            search() {
                this.loading = 1
                const params = this.clearParams(this.filter);
                this.$inertia.get(route("admin.users.index"), params);
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
