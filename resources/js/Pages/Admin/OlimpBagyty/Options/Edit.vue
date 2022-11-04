<template>
   <head>
        <title>Админ панель | Олимпиада | Бағыт қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
              <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Сыныптар қосу</h1>
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
                            <a :href="route('admin.olimpiadaOption.index', bagyt_id)">
                                <i class="fas fa-dashboard"></i>
                                Олимпиада бағыт
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Сыныптар қосу</li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                       <div class="form-group">
                           <label for="">Бағыт атауы</label>
                           <input
                               type="text"
                               class="form-control"
                               v-model="option.o_tury"
                               name="name"
                               placeholder="Бағыт атауы"
                           />
                           <validation-error :field="'o_tury'" />
                       </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    v-model="option.enable"
                                    class="custom-control-input"
                                    id="customSwitch2"
                                    true-value=1
                                    false-value=0
                                />
                                <label
                                    class="custom-control-label"
                                    for="customSwitch2"
                                    >Белсенді ({{ option.enable == 1 ? 'Иә': 'Жоқ'}})</label
                                >
                            </div>
                            <validation-error :field="'enable'" />
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
import AdminLayout from "../../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../../Components/Pagination.vue";
import ValidationError from "../../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    props: ['option'],
    data() {
        return {
            bagyt_id: route().params.bagyt,
        }
    },
    methods: {
        submit() {
            this.$inertia.put(
                route("admin.olimpiadaOption.update", [this.bagyt_id,this.option.idd]),
                this.option,
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
