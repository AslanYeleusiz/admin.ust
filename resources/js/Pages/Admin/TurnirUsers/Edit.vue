<template>
    <head>
        <title>Админ панель | Турнир қатысушы</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Турнир қатысушы № {{ user.id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.turnirUser.index')">
                                <i class="fas fa-dashboard"></i>
                                Турнир қатысушылар
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Турнир қатысушы № {{ user.id }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Турнир жайлы ақпарат
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div
                            class="col-12 col-md-12 col-lg-12 order-2 order-md-1"
                        >
                            <div class="row">
                                <div class="col-12">
                                    <div class="post">
                                        <div class="user-block">
                                            <span
                                                class="username"
                                                style="
                                                    margin-left: 0 !important;
                                                "
                                            >
                                               Турнир аты:
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.turnir.edit',
                                                            user.turnir_id
                                                        )
                                                    "
                                                    >{{ user.turnir_name }}
                                                </Link>
                                            </span>
                                            <span
                                                class="description"
                                                style="
                                                    margin-left: 0 !important;
                                                "
                                                >Жарияланған уақыты -
                                                {{
                                                    user.date
                                                        ? new Date(
                                                              user.date
                                                          ).toLocaleDateString()
                                                        : "Анықталмады"
                                                }}</span
                                            >
                                        </div>
                                        <p class="mb-0">
                                            <b>Турнир ID:</b>
                                            {{ user.turnir_id }}
                                        </p>
                                        <template v-if="user.turnir">
                                            <p class="mb-0">
                                                <b>Категория:</b>
                                                {{ user.turnir.cat_name }}
                                            </p>
                                            <p class="mb-0">
                                                <b>Турнир жарнасы:</b>
                                                {{ user.turnir.price }}
                                            </p>
                                            <p class="mb-0">
                                                <b>Бұрынғы жарнасы:</b>
                                                {{ user.turnir.old_price }}
                                            </p>
                                        </template>



                                    </div>
                                    <h4>Қолданушы</h4>
                                    <div class="post">
                                        <div class="user-block">
                                            <img
                                                class="img-circle img-bordered-sm"
                                                :src="
                                                    user.user.avatar
                                                        ? route('admin.index') +
                                                          user.user.avatar
                                                        : route('admin.index') +
                                                          '/images/user.png'
                                                "
                                                alt="user image"
                                            />
                                            <span class="username">
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.users.edit',

                                                            user.user_id
                                                        )
                                                    "
                                                >
                                                    {{
                                                        user.fio_user
                                                    }}
                                                </Link>
                                            </span>
                                            <span class="description"
                                                >Тіркелген уақыты -
                                                {{
                                                    user.user.created_at
                                                        ? new Date(
                                                              user.user.created_at
                                                          ).toLocaleDateString()
                                                        : "Анықталмады"
                                                }}</span
                                            >
                                        </div>
                                        <p class="mb-0">
                                            <b>Қолданушы ID:</b>
                                            {{ user.user_id }}
                                        </p>

                                        <p class="mb-0">
                                            <b>Жұмыс орны:</b>
                                            {{ user.work_user ?? 'Тіркелмеген' }}
                                        </p>

                                        <p class="mb-0">
                                            <b>Тіркелген код нөмірі:</b>
                                            {{ user.order_id }}
                                        </p>

                                        <p class="mb-0">
                                            <b>Төлем жасалды:</b>
                                            {{ user.success ? 'Ия' : 'Жоқ' }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Қатысты:</b>
                                            {{ user.go ? 'Ия' : 'Жоқ' }}
                                        </p>
                                        <p v-if="user.go" class="mb-0">
                                            <b>Дұрыс / Қате:</b>
                                            {{ user.durys+' / '+user.kate }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Тапсыру мүмкіндік саны:</b>
                                            {{ user.chance }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Өзгерту мүмкіндік саны:</b>
                                            {{ user.update_count }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Бастау уақыты:</b>
                                            {{
                                                user.date
                                                    ? new Date(
                                                          user.date
                                                      ).toLocaleDateString()
                                                    : "Анықталмады"
                                            }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Аяқтау уақыты:</b>
                                            {{
                                                user.date_end
                                                    ? new Date(
                                                          user.date_end
                                                      ).toLocaleDateString()
                                                    : "Анықталмады"
                                            }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Мұрағатта:</b>
                                            {{ user.muragatta ? 'Ия' : 'Жоқ' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Өзгерту</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Толық аты жөні</label>
                                <input type="text" class="form-control" v-model="user.fio_user" name="title" placeholder="ФИО" />
                                <validation-error :field="'fio_user'" />
                            </div>
                            <div class="form-group">
                                <label for="">Өзгерту мүмкіндік саны</label>
                                <input type="number" class="form-control" v-model="user.update_count" name="title" placeholder="Өзгерту мүмкіндік саны" />
                                <validation-error :field="'fio_user'" />
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" v-model="user.success" class="custom-control-input" id="customSwitch1" v-bind:true-value=1 v-bind:false-value=0 />
                                    <label class="custom-control-label" for="customSwitch1">Төлем жасалды</label>
                                </div>
                                <validation-error :field="'zhinak'" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success mr-2 " @click.prevent="submit()">
                        Сақтау
                    </button>
                    <button @click.prevent="back()" class="btn btn-danger">
                        Артқа
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head,
    },
    props: ["user"],
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
        submit() {
            let data = {};
            data["_method"] = "put";
            data.fio_user = this.user.fio_user;
            data.update_count = this.user.update_count;
            data.success = this.user.success;
            this.$inertia.post(
                route("admin.turnirUser.update", this.user.id),
                data,
                {
                    forceFormData: true,
                    onError: () => console.log("An error has occurred"),
                    onSuccess: (res) => {
                        console.log("res", res);
                        console.log("The new contact has been saved");
                    },
                }
            );
        },
    },
};
</script>
