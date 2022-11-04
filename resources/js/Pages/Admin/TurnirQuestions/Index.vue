<template>
       <head>
        <title>Админ панель | Турнир сұрақтар тізімі</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Турнир сұрақтар тізімі</h1>
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
                            Турнир сұрақтар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.turnirQuestions.create', turnir_id)">
                    <i class="fa fa-plus"></i> Қосу
                </Link>
                <Link
                    class="btn btn-danger"
                    :href="route('admin.turnirQuestions.index',{turnir: turnir_id})"
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
                                        <th>Сұрақ</th>
                                        <th>Белсенді</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.questionName"
                                                class="form-control"
                                                placeholder="Тақырыбы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <select
                                                class="form-control"
                                                @change.prevent="search"
                                                v-model="filter.question_active"
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
                                            turnirQuestion, index
                                        ) in turnirQuestions"
                                        :key="'turnirQuestion' + turnirQuestion.id"
                                    >
                                        <td>
                                            {{
                                                turnirQuestions.from
                                                    ? turnirQuestions.from + index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td v-html="turnirQuestion.question"></td>

                                        <td>
                                            <span
                                                class="badge badge-success"
                                                :class="{
                                                    'badge-success':
                                                        turnirQuestion.question_active ==
                                                        1,
                                                    'badge-danger':
                                                        turnirQuestion.question_active ==
                                                        0,
                                                }"
                                            >
                                                {{
                                                    getStatusText(
                                                        turnirQuestion.question_active
                                                    )
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.turnirQuestions.edit',
                                                            {
                                                            turnir: turnir_id,
                                                            question: turnirQuestion.id
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
                                                        deleteData(turnirQuestion.id)
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
<!--                    <Pagination :links="turnirQuestions.links" />-->
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
        "turnir_id",
        "turnirQuestions",
    ],
    data() {
        return {
            filter: {
                questionName: route().params.questionName ? route().params.questionName : null,
                question_active: route().params.question_active
                    ? route().params.question_active
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
                this.$inertia.delete(route("admin.turnirQuestions.destroy", {turnir: this.turnir_id, question: id}));
                }
            });

        },
        getStatusText(e){
            if(e) return "Белсенді"
            return "Белсенді емес"
        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route("admin.turnirQuestions.index", {turnir: this.turnir_id}), params);
        },
    },
};
</script>
