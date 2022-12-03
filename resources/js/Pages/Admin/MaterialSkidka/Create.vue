<template>
  <head>
        <title>Админ панель | Материал скидка қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Скидка қосу</h1>
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
                            <a :href="route('admin.materialSkidka.index')">
                                <i class="fas fa-dashboard"></i>
                                Материал скидка тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Скидка қосу
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
                            <label for="">Материал</label>
                            <div class="row">
                                <input
                                    type="number"
                                    class="form-control col-md-2"
                                    v-model="materialSkidka.doc_id"
                                    name="doc_id"
                                    placeholder="Материал ID"
                                />
                                <div class="nemese col-md-1 aj-c">немесе</div>
                                <input
                                    type="text"
                                    class="form-control col-md-9"
                                    v-model="materialSkidka.doc_name"
                                    name="doc_id"
                                    placeholder="Материал тақырыбы"
                                />
                            </div>
                            <validation-error :field="'doc_id'" />
                            <validation-error :field="'doc_name'" />
                        </div>
                        <div class="form-group">
                            <label for="">Скидка</label>
                            <input
                                type="number"
                                class="form-control"
                                v-model="materialSkidka.skidka"
                                name="skidka"
                                placeholder="30"
                            />
                            <validation-error :field="'skidka'" />
                        </div>
                        <div class="form-group">
                            <label for="">Жарамдылық уақыты</label>
                            <div class="d-flex">
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="materialSkidka.from_date"
                                    name="from_date"
                                    placeholder="От"
                                />
                                <input
                                    type="date"
                                    class="form-control ml-2"
                                    v-model="materialSkidka.to_date"
                                    name="to_date"
                                    placeholder="До"
                                />
                            </div>
                            <validation-error :field="'from_date'" />
                            <validation-error :field="'to_date'" />
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
    data() {
        return {
            materialSkidka: {
                doc_id: null,
                doc_name: null,
                skidka: null,
                from_date: null,
                to_date: null,
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(
                route("admin.materialSkidka.store"),
                this.materialSkidka,
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
<style>
    .aj-c{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .nemese{
        color: #999999;
    }
</style>
