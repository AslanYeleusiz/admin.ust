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
                            <label>Сыныптар</label>
                            <ul class="ul-li-no-style">
                                <li>
                                    <input type="checkbox" v-model="selectAllClassItems" />
                                    <label class="ml-1">Барлығы</label>
                                </li>
                                <li v-for="classItem in classItems" :key="'classItem' + classItem.id">
                                    <input :id="'classItem' + classItem.name" v-model="classIds" type="checkbox" :value="classItem.id" />
                                    <label class="ml-1" :for="'classItem' + classItem.name">
                                        {{ classItem.name }}
                                    </label>
                                </li>
                            </ul>
                            <validation-error :field="'class_ids'" />
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
    props: ['classItems'],
    data() {
        return {
            option: {
                o_tury: null,
                enable: 0,
            },
            bagyt_id: route().params.bagyt,
            selectAllClassItems: false,
            classIds: [],
        }
    },
    methods: {
        submit() {
            if(this.classIds.length == 0) this.option.class_ids = null
            else this.option.class_ids = this.classIds
            this.$inertia.post(
                route("admin.olimpiadaOption.store", this.bagyt_id),
                this.option,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
    watch: {
        selectAllClassItems: {
            handler(val, oldVal) {
                if (val) {
                    this.classIds = this.classItems.map((item) => item.id);
                } else {
                    this.classIds = [];
                }
            },
        },
    }
};
</script>
