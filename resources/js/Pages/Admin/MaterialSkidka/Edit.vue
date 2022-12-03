<template>
  <head>
        <title>Админ панель | Материал скидка өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Скидка өзгерту</h1>
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
                            Скидка өзгерту
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
    props: ['materialSkidka'],
    methods: {
        submit() {
            this.$inertia.put(
                route("admin.materialSkidka.update", this.materialSkidka.id),
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
