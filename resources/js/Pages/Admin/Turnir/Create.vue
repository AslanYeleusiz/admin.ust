<template>
  <head>
        <title>Админ панель | Турнир қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Турнир қосу</h1>
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
                            <a :href="route('admin.turnir.index')">
                                <i class="fas fa-dashboard"></i>
                                Турнирлер тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Турнир қосу
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
                            <label for="">Тақырыбы</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="turnir.name"
                                name="name"
                                placeholder="Тақырыбы"
                            />
                            <validation-error :field="'name'" />
                        </div>
                        <div class="form-group">
                            <label for="">Категория</label>
                            <select
                                class="form-control"
                                v-model="turnir.category"
                                placeholder="Категория"
                            >
                                <option hidden :value="null">
                                    Категория тандаңыз
                                </option>
                                <option
                                   v-for="(category, index) in categories"
                                   :value="index+1"
                                   >
                                    {{category}}
                                </option>
                            </select>
                            <validation-error :field="'category'" />
                        </div>
                        <div class="form-group">
                            <label for="">Белсенді мезгіл айы</label>
                            <select
                                class="form-control"
                                v-model="turnir.month"
                                placeholder="Категория"
                            >
                                <option hidden :value="null">
                                    Белсенді мезгілін таңдаңыз
                                </option>
                                <option
                                   v-for="m in month"
                                   :value="m.id"
                                   >
                                    {{m.month}}
                                </option>
                            </select>
                            <validation-error :field="'month'" />
                        </div>
                        <div class="form-group">
                            <label for="">Бағасы</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="turnir.price"
                                name="price"
                                placeholder="Бағасы"
                            />
                            <validation-error :field="'price'" />
                        </div>
                        <div class="form-group">
                            <label for="">Бұрынғы бағасы</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="turnir.old_price"
                                name="old_price"
                                placeholder="Бұрынғы бағасы"
                            />
                            <validation-error :field="'old_price'" />
                        </div>
                        <div class="form-group">
                            <label for="">rate</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="turnir.rate"
                                name="rate"
                                placeholder="168"
                            />
                            <validation-error :field="'rate'" />
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    v-model="turnir.active"
                                    class="custom-control-input"
                                    id="customSwitch2"
                                />
                                <label
                                    class="custom-control-label"
                                    for="customSwitch2"
                                    >Белсенді ({{ turnir.active ? 'Иә': 'Жоқ'}})</label
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
    props: ['month'],
    data() {
        return {
            categories: ["Тәрбиешілерге", "Ұстаздарға", "Оқушыларға", "Студенттерге"],
            turnir: {
                name: null,
                category: null,
                month: null,
                price: null,
                old_price: null,
                rate: null,
                active: null,
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(
                route("admin.turnir.store"),
                this.turnir,
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
