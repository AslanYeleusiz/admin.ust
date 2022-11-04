<template>
    <head>
        <title>Админ панель | Материал пікірлері</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs> </template>
        <template #header>
            <div class="buttons">
                <Link
                    class="btn btn-danger"
                    :href="route('admin.materials.comments', this.material.id)"
                >
                    <i class="fa fa-trash"></i> Фильтрді тазалау
                </Link>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table
                                class="table table-hover table-bordered table-striped dataTable dtr-inline"
                            >
                                <thead>
                                    <tr role="row">
                                        <th>№</th>
                                        <th>Қолданушы</th>
                                        <th>Пікір</th>
                                        <th>Күні</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input
                                                v-model="filter.full_name"
                                                class="form-control"
                                                placeholder="Қолданушы"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="filter.text"
                                                class="form-control"
                                                placeholder="Пікір"
                                                @keyup.enter="search"
                                            />
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="odd"
                                        v-for="(
                                            comment, index
                                        ) in material.comments"
                                        :key="'comment' + comment.id"
                                    >
                                        <td>
                                            {{ index + 1 }}
                                        </td>
                                        <td>{{ comment.user.full_name }}</td>
                                        <td>{{ comment.text }}</td>
                                        <td>{{ comment.created_at }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button
                                                    @click.prevent="
                                                        deleteData(comment.id)
                                                    "
                                                    class="btn btn-danger"
                                                    title="Жою"
                                                >
                                                    <i
                                                        class="fas fa-times"
                                                    ></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        Head,
    },
    props: ["material"],
    data() {
        return {
            filter: {
                full_name: route().params.full_name
                    ? route().params.full_name
                    : null,
                text: route().params.text ? route().params.text : null,
            },
        };
    },
    methods: {
        deleteData(id) {
            this.$inertia.delete(
                route("admin.materials.commentsDelete", {
                    id: this.material.id,
                    comment_id: id,
                })
            );
        },
        search() {
            const params = this.clearParams(this.filter);
            this.$inertia.get(
                route("admin.materials.comments", { id: this.material.id }),
                params
            );
        },
    },
};
</script>
