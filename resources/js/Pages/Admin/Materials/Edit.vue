<template>

    <head>
        <title>Админ панель | Материалды өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Материал № {{ material.id }}</h1>
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
                            <a :href="route('admin.materials.index')">
                                <i class="fas fa-dashboard"></i>
                                Материалдар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Материал № {{ material.id }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Автор
                                        <Link class="ml-2" :href="
                                        route(
                                            'admin.users.edit',
                                            material.user.id
                                        )
                                    ">
                                        <i class="fas fa-link"></i>
                                        </Link>
                                    </label>
                                    <input type="text" class="form-control" v-model="material.user.username" name="user_id" placeholder="Автор" disabled />
                                </div>
                                <div class="form-group">
                                    <label for="">Тақырыбы</label>
                                    <input type="text" class="form-control" v-model="material.title" name="title" placeholder="Тақырыбы" />
                                    <validation-error :field="'title'" />
                                </div>
                                <div class="form-group">
                                    <label for="">Түсініктеме</label>
                                    <textarea class="form-control" v-model="material.description" placeholder="Түсініктеме" name="description" cols="30" rows="5">
                                    </textarea>
                                    <validation-error :field="'description'" />
                                </div>
                                <div class="form-group">
                                    <label for="">Пәні</label>
                                    <select class="form-control" v-model="material.zhanr" name="subject_id">
                                        <option :value="material.zhanr" selected>{{ material.zhanr }}</option>
                                        <option v-for="subject in materialSubjects" :value="subject.name" :key="'subject' + subject.name">
                                            {{ subject.name }}
                                        </option>
                                    </select>
                                    <validation-error :field="'subject_id'" />
                                </div>
                                <div class="form-group">
                                    <label for="">Бағыты</label>
                                    <select class="form-control" v-model="material.zhanr2" name="direction_id">
                                        <option :value="material.zhanr2" selected>{{ material.zhanr2 }}</option>
                                        <option :value="direction.name" v-for="direction in materialDirections" :key="'direction' + direction.name">
                                            {{ direction.name }}
                                        </option>
                                    </select>
                                    <validation-error :field="'direction_id'" />
                                </div>
                                <div class="form-group">
                                    <label for="">Сыныбы</label>
                                    <select class="form-control" v-model="material.zhanr3" name="class_id">
                                        <option :value="material.zhanr3" selected>{{ material.zhanr3 }}</option>
                                        <option :value="classItem.name" v-for="classItem in materialClasses" :key="'classItem' + classItem.name">
                                            {{ classItem.name }}
                                        </option>
                                    </select>
                                    <validation-error :field="'class_id'" />
                                </div>
                                <div class="form-group">
                                    <label for="">Жүктелген уақыты</label>
                                    <input type="text" class="form-control" v-model="material.date" name="date" placeholder="Жүктелген уақыты" />
                                    <validation-error :field="'date'" />
                                </div>
                                <div class="form-group">
                                    <label for="">Қаралым саны</label>
                                    <input type="text" class="form-control" v-model="material.view" name="title" placeholder="Қаралым саны" />
                                    <validation-error :field="'view'" />
                                </div>

                                <div class="form-group">
                                    <label for="">Жүктеулер саны</label>
                                    <input type="text" class="form-control" v-model="material.download" name="title" placeholder="Жүктеулер саны" />
                                    <validation-error :field="'download'" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <template v-if="material.raw=='docx'||material.raw=='doc'||material.raw=='pptx'">
                                    <iframe :src="'https://view.officeapps.live.com/op/embed.aspx?src=ust.kz/frontend/web/'+material.file_doc" width='100%' height='720px' frameborder='0'></iframe>
                                </template>
                                <template v-if="material.raw=='pdf'">
                                    <iframe id="iframepdf" width='100%' height='720px' :src="'https://ust.kz/frontend/web/'+material.file_doc" frameborder='0'></iframe>
                                </template>
                                <div class="form-group file-upload">
                                    <label for="">Файл</label>
                                    <div class="ml-2">
                                        <p v-if="material.filename && !file.file" v-html="material.filename" style="padding-bottom: 10px"></p>
                                        <p v-show="file.file" v-html="file.file.name" style="padding-bottom: 10px"></p>
                                        <div class="row">
                                            <div class="file-input" style="margin-right: 10px">
                                                <button hidden name="filename" @click="handleDownload()" class="file" id="download" />
                                                <label for="download"> Жүктеу </label>
                                            </div>
                                        </div>
                                    </div>
                                    <validation-error :field="'filename'" />
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="">Автор</label>
                        <input type="text" class="form-control" v-model="material.author" placeholder="Автор" />
                        <validation-error :field="'author'" />
                    </div>
                    <div class="form-group">
                        <label for="">Жұмыс орны</label>
                        <input type="text" class="form-control" v-model="material.work" placeholder="Жұмыс орны" />
                        <validation-error :field="'work'" />
                    </div>
                    <div class="form-group">
                        <label for="">Бағасы</label>
                        <input type="number" class="form-control" v-model="material.sell" placeholder="Бағасы" />
                        <validation-error :field="'sell'" />
                    </div>
                    <div class="form-group">
                        <label for="">Лайк</label>
                        <input type="number" class="form-control" v-model="material.likes" placeholder="Лайк саны" />
                        <validation-error :field="'likes'" />
                    </div>
                    <div class="form-group">
                        <label for="">Дизлайк</label>
                        <input type="number" class="form-control" v-model="material.dislikes" placeholder="Дизлайк саны" />
                        <validation-error :field="'dislikes'" />
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" v-model="material.zhinak" class="custom-control-input" id="customSwitch1" v-bind:true-value="1" v-bind:false-value="0" />
                            <label class="custom-control-label" for="customSwitch1">Жинақ</label>
                        </div>
                        <validation-error :field="'zhinak'" />
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
            Head,
        },
        props: [
            "material",
            "materialClasses",
            "materialSubjects",
            "materialDirections",
        ],
        data() {
            return {
                file: {
                    file: "",
                },
            };
        },
        methods: {
            submit() {
                if (this.file.file) {
                    this.material.filename = this.file.file;
                }
                this.material["_method"] = "put";
                this.$inertia.post(
                    route("admin.materials.update", this.material.id),
                    this.material, {
                        forceFormData: true,
                        onError: () => console.log("An error has occurred"),
                        onSuccess: (res) => {
                            this.file = {
                                file: "",
                            };
                            console.log("res", res);
                            console.log("The new contact has been saved");
                        },
                    }
                );
            },
            handleImageUpload() {
                this.file.file = this.$refs.file.files[0];
                console.log("file.file0", this.file.file);
                if (this.file.file) {
                    this.$refs.file.value = "";
                } else {
                    this.material.file_name = "";
                    this.file.file = "";
                }
            },
            handleDownload() {
                window.location.href = "https://ust.kz/frontend/web/"+this.material.file_doc
            },

        },
        mounted() {
            // this.$refs.file.value = "";
        },
    };

</script>
<style lang="scss">
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        height: auto;
    }

    .file-upload {
        .file {
            opacity: 0;
            width: 0.1px;
            height: 0.1px;
        }

        .file-input label {
            width: 158px;
            height: 40px;
            border-radius: 5px;
            border-color: #ddd;
            background: #eee;
            box-shadow: 0 3px 4px rgb(0 0 0 / 40%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            cursor: pointer;
            transition: transform 0.2s ease-out;
        }

        input:hover+label,
        input:focus+label {
            transform: scale(1.02);
        }
    }

    /* Firefox */

</style>
