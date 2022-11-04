<template>
  <head>
        <title>Админ панель | Сұрақ өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Турнир сұрақ өзгерту</h1>
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
                            <a :href="route('admin.turnirAllQuestions.index')">
                                <i class="fas fa-dashboard"></i>
                                Сұрақтар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Турнир сұрақ өзгерту
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                    <form @submit.prevent="submit">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="odd even">
                                    <td class="w-25"><b>Сұрақ</b> <i class="red">*</i></td>
                                    <td id="turnirQuestion">
                                        <div v-if="input_type === 'ckeditor'">
                                            <ckeditor :editor="editor" v-model="turnirQuestion.question" :config="editorConfig" class="form-control"></ckeditor>
                                            <a class="d-block mt-2" href="https://latex.codecogs.com/eqneditor/editor.php" target="_blank">Latex формула</a>
                                        </div>
                                        <input v-else v-model="turnirQuestion.question" type="text" class="form-control" />
                                        <validation-error :field="'text'" />
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
                                <tr class="odd even">
                                    <td>
                                        <b>{{getAnswerOptionTextType(1)}}</b>
                                        <i class="red">*</i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input v-model="turnirQuestion.correct_answer" class="select-answer mr-2 h-25" type="radio" name="Buttonradio25" value=1 />
                                            <ckeditor v-if="input_type === 'ckeditor'" :editor="editor" v-model="turnirQuestion.answer1" :config="editorConfig" class="form-control"></ckeditor>
                                            <input v-else v-model="turnirQuestion.answer1" type="text" class="form-control" />
                                        </div>
                                        <validation-error :field="`answers.${index}.text`" />
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td>
                                        <b>{{getAnswerOptionTextType(2)}}</b>
                                        <i class="red">*</i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input v-model="turnirQuestion.correct_answer" class="select-answer mr-2 h-25" type="radio" name="Buttonradio25" :value=2 />
                                            <ckeditor v-if="input_type === 'ckeditor'" :editor="editor" v-model="turnirQuestion.answer2" :config="editorConfig" class="form-control"></ckeditor>
                                            <input v-else v-model="turnirQuestion.answer1" type="text" class="form-control" />
                                        </div>
                                        <validation-error :field="`answers.${index}.text`" />
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td>
                                        <b>{{getAnswerOptionTextType(3)}}</b>
                                        <i class="red">*</i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input v-model="turnirQuestion.correct_answer" class="select-answer mr-2 h-25" type="radio" name="Buttonradio25" :value=3 />
                                            <ckeditor v-if="input_type === 'ckeditor'" :editor="editor" v-model="turnirQuestion.answer3" :config="editorConfig" class="form-control"></ckeditor>
                                            <input v-else v-model="turnirQuestion.answer1" type="text" class="form-control" />
                                        </div>
                                        <validation-error :field="`answers.${index}.text`" />
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td>
                                        <b>{{getAnswerOptionTextType(4)}}</b>
                                        <i class="red">*</i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input v-model="turnirQuestion.correct_answer" class="select-answer mr-2 h-25" type="radio" name="Buttonradio25" :value=4 />
                                            <ckeditor v-if="input_type === 'ckeditor'" :editor="editor" v-model="turnirQuestion.answer4" :config="editorConfig" class="form-control"></ckeditor>
                                            <input v-else v-model="turnirQuestion.answer1" type="text" class="form-control" />
                                        </div>
                                        <validation-error :field="`answers.${index}.text`" />
                                    </td>
                                </tr>

                                <tr class="odd even">
                                    <td>
                                        <b>Белсенді/ Белсенді емес </b>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" v-model="turnirQuestion.question_active" true-value="1" false-value="0"  class="custom-control-input" id="customSwitch1" />
                                            <label class="custom-control-label" for="customSwitch1">Белсенді/Белсенді емес</label>
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
                    </form>
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    props: ['turnirQuestion'],
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
//                extraPlugins: [this.uploader],
            },
            input_type: "input",
            categories: ["Тәрбиешілерге", "Ұстаздарға", "Оқушыларға", "Студенттерге"],
        }
    },
    methods: {
        submit() {
            this.$inertia.put(
                route("admin.turnirAllQuestions.update", this.turnirQuestion.id),
                this.turnirQuestion,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
        getCategory(e){
            switch(e){
                case 1: return "Тәрбиешілерге"
                case 2: return "Ұстаздарға"
                case 3: return "Оқушыларға"
                case 4: return "Студенттерге"
            }
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
            }
        },
    },
};
</script>
<style scoped>
    .mr-10 {
        margin-right: 10px;
    }

    p {
        margin-bottom: 0 !important;
    }

    .h-25 {
        height: 25px;
    }

</style>
