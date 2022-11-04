<template>
       <head>
        <title>Админ панель | Турнирлер</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Турнирлер тізімі</h1>
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
                            Турнирлер тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.turnir.create')">
                    <i class="fa fa-plus"></i> Қосу
                </Link>
                <Link
                    class="btn btn-danger"
                    :href="route('admin.turnir.index')"
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
                                        <th>Категория</th>
                                        <th>Бағасы</th>
                                        <th>Бұрынғы бағасы</th>
                                        <th>Сұрақ саны</th>
                                        <th>Белсенді</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.name"
                                                class="form-control"
                                                placeholder="Тақырыбы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <select
                                                v-model="filter.category"
                                                class="form-control"
                                                placeholder="Категория"
                                                @change.prevent="search"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option
                                                    :value="index+1"
                                                    :key="
                                                        'category' +
                                                        index
                                                    "
                                                    v-for="(category, index) in categories"
                                                >
                                                    {{ category }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.price"
                                                class="form-control"
                                                placeholder="Бағасы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.old_price"
                                                class="form-control"
                                                placeholder="Бұрынғы бағасы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td></td>
                                        <td>
                                            <select
                                                class="form-control"
                                                @change.prevent="search"
                                                v-model="filter.active"
                                                placeholder="Белсенді"
                                            >
                                                <option :value="null">
                                                    Барлығы
                                                </option>
                                                <option value="0">
                                                    Белсенді емес
                                                </option>
                                                <option value="1">
                                                    Белсенді
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
                                            turnir, index
                                        ) in turnirs.data"
                                        :key="'turnir' + turnir.id"
                                    >
                                        <td>
                                            {{
                                                turnirs.from
                                                    ? turnirs.from + index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>{{ turnir.name }}</td>
                                        <td>{{ getCategory(turnir.category) }}</td>
                                        <td>{{ turnir.price }}</td>
                                        <td>{{ turnir.old_price }}</td>
                                        <td>{{ turnir.questions_count }}</td>
                                        <td>
                                            <span
                                                class="badge badge-success"
                                                :class="{
                                                    'badge-success':
                                                        turnir.active ==
                                                        1,
                                                    'badge-danger':
                                                        turnir.active ==
                                                        0,
                                                }"
                                            >
                                                {{
                                                    getStatusText(
                                                        turnir.active
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.turnirQuestions.index',
                                                            { id: turnir.id }
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
                                                            'admin.turnir.edit',
                                                            turnir
                                                        )
                                                    "
                                                    class="btn btn-primary"
                                                    title="Изменить"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteData(turnir.id)
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
                    <Pagination :links="turnirs.links" />
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
        "turnirs",
    ],
    data() {
        return {
            categories: ["Тәрбиешілерге", "Ұстаздарға", "Оқушыларға", "Студенттерге"],
            filter: {
                name: route().params.name ? route().params.name : null,
                category: route().params.category
                    ? route().params.category
                    : null,
                price: route().params.price
                    ? route().params.price
                    : null,
                old_price: route().params.old_price
                    ? route().params.old_price
                    : null,
                active: route().params.active
                    ? route().params.active
                    : null,
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
                this.$inertia.delete(route("admin.turnir.destroy", id));
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
            this.$inertia.get(route("admin.turnir.index"), params);
        },
    },
};
</script>
