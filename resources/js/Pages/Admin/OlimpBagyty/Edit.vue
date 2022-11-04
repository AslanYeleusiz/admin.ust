<template>
  <head>
        <title>Админ панель | Олимпиада бағыт қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Бағыт қосу</h1>
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
                            <a :href="route('admin.olimpiadaBagyty.index')">
                                <i class="fas fa-dashboard"></i>
                                Олимпиада бағыт тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Бағыт қосу
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
                            <label for="">Олимпиада бағыт толық аты</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="bagyt.o_bagyty"
                                name="o_bagyty"
                                placeholder="Қазақ тілі мен әдебиеті пәні бойынша ұстаздар арасындағы олимпиада"
                            />
                            <validation-error :field="'o_bagyty'" />
                        </div>
                        <div class="form-group">
                            <label for="">Бағыт қысқа атауы</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="bagyt.bagyt"
                                name="bagyt"
                                placeholder="Қазақ тілі мен әдебиеті"
                            />
                            <validation-error :field="'bagyt'" />
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    v-model="bagyt.enable"
                                    class="custom-control-input"
                                    id="customSwitch2"
                                    true-value=1
                                    false-value=0
                                />
                                <label
                                    class="custom-control-label"
                                    for="customSwitch2"
                                    >Белсенді ({{ bagyt.enable == 1 ? 'Иә': 'Жоқ'}})</label
                                >
                            </div>
                            <validation-error :field="'active'" />
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
import { Link, Head } from "@inertiajs/inertia-vue3";
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
    props: ['bagyt'],
    data() {
        return {
            //
        }
    },
    methods: {
        submit() {
            this.$inertia.put(
                route("admin.olimpiadaBagyty.update", this.bagyt.idd),
                this.bagyt,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
};
</script>
