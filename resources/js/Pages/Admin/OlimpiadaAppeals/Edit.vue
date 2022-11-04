<template>

    <head>
        <title>Админ панель | Олимпиада | Сұрақ өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Сұрақ өзгерту</h1>
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
                            <a :href="route('admin.olimpiadaAppeals.index', [
                               bagyt_id,
                               option_id
                            ])">
                                <i class="fas fa-dashboard"></i>
                                Олимпиада бағыт
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Сұрақ өзгерту</li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-footer">
                        <div class="card-header">
                            <h3 class="card-title">
                                Олимпиадаға қатысу жайлы ақпарат
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div v-if="surak.bagyty" class="post">
                                                <div class="user-block">
                                                    <span class="username" style="
                                                    margin-left: 0 !important;
                                                ">
                                                        Олимпиада атауы: {{ surak.tury.o_tury }}
                                                    </span>
                                                </div>
                                                <p class="mb-0">
                                                    <b>Категория:</b>
                                                    {{ surak.bagyty.katysushilar }}
                                                </p>
                                                <p class="mb-0">
                                                    <b>Бағыт:</b>
                                                    {{ surak.bagyty.bagyt }}
                                                </p>
                                                <p class="mb-0">
                                                    <b>Олимпиада түрі:</b>
                                                    {{ types[surak.bagyty.type-1] }}
                                                </p>
                                                <p class="mb-0 mt-3">
                                                    <b>Қате түрі:</b>
                                                    {{ appeal.variable }}
                                                </p>
                                                <p v-if="appeal.text" class="mb-0">
                                                    <b>Комментарии:</b>
                                                    {{ appeal.text }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="odd even">
                                        <td class="w-25"><b>Сұрақ</b> <i class="red">*</i></td>
                                        <td id="turnirQuestion">
                                            <div v-if="input_type === 'ckeditor'">
                                                <ckeditor :editor="editor" v-model="surak.surak" :config="editorConfig" class="form-control"></ckeditor>
                                                <a class="d-block mt-2" href="https://latex.codecogs.com/eqneditor/editor.php" target="_blank">Latex формула</a>
                                            </div>
                                            <input v-else v-model="surak.surak" type="text" class="form-control" />
                                            <validation-error :field="'surak'" />
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td>Жауап нұсқаларын енгізіңіз:</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center mr-2">
                                                    <input v-model="input_type" type="radio" class="select-answer" value="input" />
                                                    <p class="ml-2">- input</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input v-model="input_type" type="radio" class="select-answer" value="ckeditor" />
                                                    <p class="ml-2">- ckeditor</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-for="(zhauap, index) in surak.zhauap" :key="'zhauap' + index" class="odd even">
                                        <td>
                                            <b>{{getAnswerOptionTextType(index+1)}}</b>
                                            <i class="red">*</i>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input v-model="surak.correct_answer_number" class="select-answer mr-2 h-25" type="radio" name="Buttonradio25" :value="index" />
                                                <ckeditor v-if="input_type === 'ckeditor'" :editor="editor" v-model="zhauap.variant" :config="editorConfig" class="form-control"></ckeditor>
                                                <input v-else v-model="zhauap.variant" type="text" class="form-control" />
                                            </div>
                                            <validation-error :field="`zhauaptar.${index}.variant`" />
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td>
                                            <b>Белсенді/ Белсенді емес </b>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" v-model="surak.archive" true-value="1" false-value="0" class="custom-control-input" id="customSwitch1" />
                                                <label class="custom-control-label" for="customSwitch1">Архив</label>
                                            </div>
                                            <validation-error :field="'is_active'" />
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td>
                                            <button class="btn btn-danger" type="button" @click.prevent="clear">
                                                <i class="fa fa-trash" /> Тазалау
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label for="">Түсінік</label>
                                <input type="text" class="form-control" v-model="surak.tusinik" name="name" placeholder="Түсінік" />
                                <validation-error :field="'tusinik'" />
                            </div>
                        </form>
                        <div class="form-group mt-5">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    v-model="appeal.is_checked"
                                    class="custom-control-input"
                                    id="customSwitch2"
                                    true-value=1
                                    false-value=0
                                />
                                <label
                                    class="custom-control-label"
                                    for="customSwitch2"
                                    >Тексерілді ({{ appeal.is_checked == 1 ? 'Иә': 'Жоқ'}})</label
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
    import {
        Link,
        Head
    } from "@inertiajs/inertia-vue3";
    import Pagination from "../../../Components/Pagination.vue";
    import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
    import ValidationError from "../../../Components/ValidationError.vue";

    export default {
        components: {
            AdminLayout,
            Link,
            Pagination,
            ValidationError,
            Head
        },
        props: ['surak', 'appeal'],
        data() {
            return {
                types: ['Облыстық', 'Республикалық', 'Халықаралық'],
                bagyt_id: route().params.bagyt,
                option_id: route().params.option,
                editor: ClassicEditor,
                input_type: "input",
                editorConfig: {
                    //
                },
            }
        },
        methods: {
            submit() {
                this.$inertia.put(
                    route("admin.olimpiadaAppeals.update", [this.appeal.id]),
                    {
                        surak: this.surak,
                        appeal: this.appeal,
                    }, {
                        onError: () => console.log("An error has occurred"),
                        onSuccess: () =>
                            console.log("The new contact has been saved"),
                    }
                );
            },
            getAnswerOptionTextType(val) {
                switch (val) {
                    case 1:
                        return "A ";
                    case 2:
                        return "B ";
                    case 3:
                        return "C ";
                    case 4:
                        return "D ";
                    case 5:
                        return "E ";
                    case 6:
                        return "F ";
                    case 7:
                        return "G ";
                    case 8:
                        return "H ";
                    case 9:
                        return "J ";
                }
            },
        },
    };

</script>
