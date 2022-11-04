<template>

    <head>
        <title>Админ панель | Қолданушы өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Қолданушы № {{ user.id}}</h1>
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
                            <a :href="route('admin.users.index')">
                                <i class="fas fa-dashboard"></i>
                                Қолданушылар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Қолданушы № {{ user.id}}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты-жөні <span class="red">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Толық аты-жөнін енгізіңіз</span>
                                </div>
                                <input type="text" class="form-control" v-model="user.s_name" name="s_name" placeholder="Аты" />
                                <input type="text" class="form-control" v-model="user.username" placeholder="Жөні" />
                                <input type="text" class="form-control" v-model="user.l_name" name="l_name" placeholder="Әкесінің аты" />
                            </div>
                            <validation-error :field="'s_name'" />
                            <validation-error :field="'username'" />
                            <validation-error :field="'l_name'" />
                        </div>

                        <div class="form-group">
                            <label for="">Email <span class="red">*</span></label>
                            <input type="email" class="form-control" v-model="user.email" name="" placeholder="Email" />
                            <validation-error :field="'email'" />
                        </div>

                        <div class="form-group">
                            <label for="">Телефон <span class="red">*</span></label>
                            <input type="text" class="form-control" v-model="user.tel_num" name="tel_num" placeholder="Телефон" autocomplete="off" />
                            <validation-error :field="'tel_num'" />
                        </div>
                        <div class="form-group">
                            <label for="">Құпиясөз <span class="red">*</span></label>
                            <input :type="passwordField" class="form-control" v-model="user.real_password" name="real_password" placeholder="Телефон" />
                            <div class="form-group mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" @change="openPassword()">
                                    <label class="form-check-label" for="gridCheck">
                                        Құпия сөзді көрсету
                                    </label>
                                </div>
                            </div>
                            <validation-error :field="'password'" />
                        </div>
                        <div class="form-group">
                            <label for="">Рөл <span class="red">*</span></label>
                            <select class="form-control" v-model="user.user_status_id" name="user_status_id">
                                <option :value="null" hidden>
                                    Рөлді таңдаңыз
                                </option>
                                <template v-for="(role, index) in roles">
                                    <option :value="index+1">
                                        {{ role }}
                                    </option>
                                </template>
                            </select>
                            <validation-error :field="'user_status_id'" />
                        </div>

                        <div class="form-group">
                            <label for="">Туған күні</label>
                            <input type="date" class="form-control" v-model="user.birthday" name="birthday" placeholder="Туған күні" />
                            <validation-error :field="'birthday'" />
                        </div>

                        <div class="form-group">
                            <label for="">Жынысы</label>
                            <select v-model="user.pol_id" class="form-control" name="pol_id">
                                <option value="null">Жынысын таңдаңыз</option>
                                <option value="1">Ер</option>
                                <option value="2">Әйел</option>
                                <option value="3">Басқа</option>
                            </select>
                            <validation-error :field="'pol_id'" />
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Баланс</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" v-model="user.balance" name="balance" placeholder="Баланс" />
                                    </div>
                                    <validation-error :field="'balance'" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Бонус</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" v-model="user.bonus" placeholder="Бонус" />
                                    </div>
                                    <validation-error :field="'bonus'" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" v-model="user.email_rastalgan" class="custom-control-input" id="customSwitch1" />
                                <label class="custom-control-label" for="customSwitch1">Email расталған</label>
                            </div>
                            <validation-error :field="'email_rastalgan'" />
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" v-model="user.phone_activated" class="custom-control-input" id="customSwitch2" />
                                <label class="custom-control-label" for="customSwitch2">Телефон расталған</label>
                            </div>
                            <validation-error :field="'phone_activated'" />
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" v-model="user.admin" class="custom-control-input" id="customSwitch3" />
                                <label class="custom-control-label" for="customSwitch3">Админ</label>
                            </div>
                            <validation-error :field="'admin'" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
                    </div>
                </form>
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
    import ValidationError from "../../../Components/ValidationError.vue";

    export default {
        components: {
            AdminLayout,
            Link,
            Pagination,
            ValidationError,
            Head
        },
        props: ["user"],
        data() {
            return {
                //         form: useForm({
                //   full_name: null,
                //   email: null,
                //   password: false,
                // })
                passwordField: 'password',
                passStat: false,
                roles: ['Педагог', 'Оқушы', 'Басқа (ата-ана т.б.)'],
            };
        },
        methods: {
            submit() {
                this.$inertia.put(
                    route("admin.users.update", this.user.id),
                    this.user, {
                        onError: () => console.log("An error has occurred"),
                        onSuccess: () =>
                            console.log("The new contact has been saved"),
                    }
                );
            },
            openPassword() {
                this.passStat = !this.passStat
                this.passwordField = this.passwordField === "password" ? "text" : "password"
            },
        },
    };

</script>
