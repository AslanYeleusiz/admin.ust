<template>
    <head>
        <title>Админ панель | Олимпиада қатысушы өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Олимпиада қатысушы № {{ user.id }}</h1>
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
                            <a :href="route('admin.olimpiadaTizim.index')">
                                <i class="fas fa-dashboard"></i>
                                Олимпиада қатысушы
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Олимпиада қатысушы № {{ user.id }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Олимпиадаға қатысу жайлы ақпарат
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div
                            class="col-12 col-md-12 col-lg-12 order-2 order-md-1"
                        >
                            <div class="row">
                                <div class="col-12">
                                    <div v-if="user.katysushy" class="post">
                                        <div class="user-block">
                                            <span
                                                class="username"
                                                style="
                                                    margin-left: 0 !important;
                                                "
                                            >
                                               Олимпиада атауы: {{ user.katysushy.bagyty.o_bagyty }}
                                            </span>
                                            <span
                                                class="description"
                                                style="
                                                    margin-left: 0 !important;
                                                "
                                                >Аяқатаған уақыты -
                                                {{
                                                    user.date
                                                        ? new Date(
                                                              user.date
                                                          ).toLocaleDateString()
                                                        : "Аяқталмады"
                                                }}</span
                                            >
                                        </div>
                                        <p class="mb-0">
                                            <b>Категория:</b>
                                            {{ user.katysushy.bagyty.katysushilar }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Бағыт:</b>
                                            {{ user.katysushy.bagyty.bagyt }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Олимпиада түрі:</b>
                                            {{ types[user.katysushy.bagyty.type-1] }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Төлем жасалды:</b>
                                            {{ user.katysushy.success ? 'Ия' : 'Жоқ' }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Тапсыру мүмкіндік саны:</b>
                                            {{ user.katysushy.o_sany }}
                                        </p>
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
                                                        (user.user.fio ?? user.user.username) ??  user.user.email
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
                                            <b>Тіркелген аты-жөні:</b>
                                            {{ user.katysushy_name }}
                                        </p>


                                        <p class="mb-0">
                                            <b>Жұмыс орны:</b>
                                            {{ user.katysushy_work ?? 'Тіркелмеген' }}
                                        </p>

                                        <p class="mb-0">
                                            <b>Тіркелген код нөмірі:</b>
                                            {{ user.code }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Тест код нөмірі:</b>
                                            {{ user.obwcode }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Мәлімет өзгерту мүмкіндік саны:</b>
                                            {{ user.ozgertu_sany }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Тапсырды:</b>
                                            {{ user.tapsyrgan ? 'Ия' : 'Жок' }}
                                        </p>
                                        <p v-if="user.tapsyrgan" class="mb-0">
                                            <b>Ұпай саны:</b>
                                            {{ user.result }}
                                        </p>
                                        <p class="mb-0">
                                            <b>Қатемен жұмыс жасалды:</b>
                                            {{ user.kjumis ? 'Ия' : 'Жок' }}
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
                                <label for="">Тіркелген аты-жөні</label>
                                <input type="text" class="form-control" v-model="user.katysushy_name" name="title" placeholder="ФИО" />
                                <validation-error :field="'katysushy_name'" />
                            </div>
                            <div class="form-group">
                                <label for="">Жұмыс орны</label>
                                <input type="text" class="form-control" v-model="user.katysushy_work" name="title" placeholder="Жұмыс орны" />
                                <validation-error :field="'katysushy_work'" />
                            </div>
                            <div class="form-group">
                                <label for="">Мәлімет өзгерту мүмкіндік саны</label>
                                <input type="number" class="form-control" v-model="user.ozgertu_sany" name="title" placeholder="Мәлімет өзгерту мүмкіндік саны" style="width: 80px;"/>
                                <validation-error :field="'ozgertu_sany'" />
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
    data() {
        return {
            types: ['Облыстық','Республикалық','Халықаралық'],
        }
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

        submit() {
            let data = {};
            data["_method"] = "put";
            data.katysushy_name = this.user.katysushy_name;
            data.katysushy_work = this.user.katysushy_work;
            data.ozgertu_sany = this.user.ozgertu_sany;
            this.$inertia.post(
                route("admin.olimpiadaTizim.update", this.user.id),
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
