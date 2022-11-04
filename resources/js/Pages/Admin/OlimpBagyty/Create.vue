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
                            <label for="">Категория</label>
                            <select
                                v-model="bagyt.o_katysushy_idd"
                                class="form-control"
                                placeholder="Категория"
                            >
                                <option hidden :value="null">
                                    Категория тандаңыз
                                </option>
                                <option
                                    :value="category.idd"
                                    :key="
                                        'category' +
                                        category.idd
                                    "
                                    v-for="category in katysushylar"
                                >
                                    {{ category.o_katysushy }}
                                </option>
                            </select>
                            <validation-error :field="'o_katysushy_idd'" />
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
                            <label>Олимпиада түрі</label>
                            <ul class="ul-li-no-style">
                                <li v-for="(type, index) in types" :key="'type' + index+1">
                                    <input :id="'type' + type" v-model="typeIds" type="checkbox" :value="index+1" />
                                    <label class="ml-1" :for="'type' + type">
                                        {{ type }}
                                    </label>
                                </li>
                            </ul>
                            <validation-error :field="'type_ids'" />
                        </div>
                        <div v-if="bagyt.o_katysushy_idd == 3" class="form-group">
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
    props: ['katysushylar', 'classItems'],
    data() {
        return {
            classIds: [],
            typeIds: [],
            selectAllClassItems: false,
            bagyt: {
                o_katysushy_idd: null,
                o_bagyty: null,
                enable: 0,
                bagyt: null,
            },
            types: ['Облыстық','Республикалық','Халықаралық'],
        }
    },
    methods: {
        submit() {
            if(this.classIds.length == 0) this.bagyt.class_ids = null
            else this.bagyt.class_ids = this.classIds
            if(this.typeIds.length == 0) this.bagyt.type_ids = null
            else this.bagyt.type_ids = this.typeIds
            this.$inertia.post(
                route("admin.olimpiadaBagyty.store"),
                this.bagyt,
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
<style scoped>
    li {
        list-style: none;
    }

    ul {
        padding-left: 20px !important;
    }

</style>
