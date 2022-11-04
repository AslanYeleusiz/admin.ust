<template>
  <head>
        <title>Админ панель | ҚМЖ бөлімдер қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Бөлім қосу</h1>
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
                            <a :href="route('admin.qmgBolim.index')">
                                <i class="fas fa-dashboard"></i>
                                ҚМЖ бөлімдер тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Бөлім қосу
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
                            <label for="">Толық атауы</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="qmgBolim.title"
                                name="title"
                                placeholder="Химия пәнінен 7-11 сыныптарға арналған Қысқа мерзімді сабақ жоспарлары"
                            />
                            <validation-error :field="'title'" />
                        </div>
                        <div class="form-group">
                            <label for="">Мерзімі</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="qmgBolim.date"
                                name="date"
                                placeholder="2022-2023 оқу жылына"
                            />
                            <validation-error :field="'date'" />
                        </div>
                        <div class="form-group">
                            <label for="">Сынып</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="qmgBolim.synyp_text"
                                name="synyp_text"
                                placeholder="7-11 сыныптарға"
                            />
                            <validation-error :field="'synyp_text'" />
                        </div>
                        <div class="form-group">
                            <label for="">Пәні</label>
                            <select
                                v-model="qmgBolim.sub_id"
                                class="form-control"
                                placeholder="Пәні"
                            >
                                <option :value="null" disabled hidden>
                                    Пән таңдаңыз
                                </option>
                                <option
                                    :value="subject.id"
                                    :key="
                                        'subject' +
                                        subject.name
                                    "
                                    v-for="subject in subjects"
                                >
                                    {{ subject.name }}
                                </option>
                            </select>
                            <validation-error :field="'sub_id'" />
                        </div>
                        <div class="form-group">
                            <label for="">Скидка (%)</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="qmgBolim.skidka"
                                name="skidka"
                                placeholder="Мысалы: 20"
                            />
                            <validation-error :field="'skidka'" />
                        </div>
                        <div class="form-group file-upload">
                            <label for="">Сурет</label>
                            <div class="ml-2">
                                <img v-if="qmgBolim.path && !image.file" :src="route('index')  +'/storage/images/' +  qmgBolim.path" height="300" alt="image" style="padding-bottom: 10px" />
                                <img v-show="image.preview" :src="image.preview" height="300" style="padding-bottom: 10px" />
                                <div class="file-input" style="margin-right: 10px">
                                    <input type="file" hidden name="image" @change="handleImageUpload()" ref="image" accept="image/jpeg,image/png" class="file" id="image" />
                                    <label for="image"> Загрузить </label>
                                </div>
                            </div>

                            <validation-error :field="'image'" />
                        </div>
                        <div class="form-group">
                            <label for="">Видео сілтеме</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="qmgBolim.video"
                                name="video"
                                placeholder="https://youtu.be/9Q888_iXcqg"
                            />
                            <validation-error :field="'video'" />
                        </div>
                        <div class="form-group file-upload">
                            <label for="">Файл</label>
                            <div class="ml-2">
                                <p
                                    v-if="qmgBolim.doc && !file.file"
                                    v-html="qmgBolim.doc"
                                    style="padding-bottom: 10px"
                                ></p>
                                <p
                                    v-show="file.file"
                                    v-html="file.file.name"
                                    style="padding-bottom: 10px"
                                ></p>
                                <div
                                    class="file-input"
                                    style="margin-right: 10px"
                                >
                                    <input
                                        type="file"
                                        hidden
                                        name="doc"
                                        @change="handleFileUpload()"
                                        ref="file"
                                        class="file"
                                        id="doc"
                                    />
                                    <label for="doc"> Загрузить </label>
                                </div>
                            </div>
                            <validation-error :field="'doc'" />
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
    props: ['subjects'],
    data() {
        return {
            qmgBolim: {
                title: null,
                date: null,
                synyp_text: null,
                sub_id: null,
                path: null,
                newPath: null,
                doc: null,
                newDoc: null,
            },

            image: {
                file: "",
                preview: "",
            },

            file: {
                file: "",
            },
        }
    },
    methods: {
        submit() {
            if(this.image.file){
                this.qmgBolim.newPath = this.image.file
                this.qmgBolim.path = this.image.file
            }
            if(this.file.file){
                this.qmgBolim.newDoc = this.file.file
                this.qmgBolim.doc = this.file.file
            }
            this.$inertia.post(
                route("admin.qmgBolim.store"),
                this.qmgBolim,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
        handleImageUpload() {
            this.image.file = this.$refs.image.files[0];
            if (this.image.file) {
                const reader = new FileReader();
                reader.onloadend = (file) => {
                    this.image.preview = reader.result;
                };
                reader.readAsDataURL(this.image.file);
                this.$refs.image.value = "";
            } else {
                this.qmgBolim.path = "";
                this.image.file = "";
                this.image.preview = "";
            }
        },
        handleFileUpload() {
            this.file.file = this.$refs.file.files[0];
            console.log("file.file0", this.file.file);
            if (this.file.file) {
                this.$refs.file.value = "";
            } else {
                this.material.file_name = "";
                this.file.file = "";
            }
        },
    },
};
</script>

<style>
    input:focus::placeholder{
        color: #ffffff;
    }
</style>
