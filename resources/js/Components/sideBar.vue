<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="../../../public/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Әкімшілік панелі</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../../../public/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <Link :href="route('admin.users.edit',user.id)" class="d-block">
                        {{ user.username }}
                    </Link>
                </div>
            </div>


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <template v-for="(menu_item, index) in menu_items" :key="'menu_item' + index">
                        <li class="nav-item " v-if="menu_item.childs_items" :class="{
                                'menu-open':
                                    menu_item.menu_active.includes(
                                        currentRoute
                                    ),
                            }">
                            <a href="#" class="nav-link" :class="{
                                    active: menu_item.menu_active.includes(
                                        currentRoute
                                    ),
                                }">
                                <i class="nav-icon fas fa-solid" :class="[menu_item.font]"></i>
                                <p>
                                    {{ menu_item.name }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ml-2" v-for="(
                                        childs_item, child_index
                                    ) in menu_item.childs_items" :key="'child' + child_index">
                                    <Link class="nav-link" :href="route(childs_item.route_name)" :class="{
                                            active: childs_item.menu_active.includes(
                                                currentRoute
                                            ),
                                        }">
                                    <i class="nav-icon fas" :class="childs_item.font"></i>
                                    <p>{{ childs_item.name }}</p>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" v-else>
                            <Link :href="route(menu_item.route_name)" class="nav-link" :class="{
                                    active: menu_item.menu_active.includes(
                                        currentRoute
                                    ),
                                }">
                            <i class="nav-icon fas" :class="menu_item.font"></i>
                            <p>{{ menu_item.name }}</p>
                            </Link>
                        </li>
                    </template>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    import {
        Link
    } from "@inertiajs/inertia-vue3";
    export default {
        components: {
            Link
        },
        data() {
            return {
                user: this.$page.props.user,
                menu_items: [{
                        name: "Қолданушылар",
                        font: "fa-users",
                        route_name: "admin.users.index",
                        menu_active: ["admin.users"],
                    },
                    {
                        name: "Материалдар",
                        font: "fa-comment-medical",
                        menu_active: [
                            "admin.materials",
                            "admin.deletedMaterials",
                            "admin.materialClasses",
                            "admin.materialDirections",
                            "admin.materialSubjects",
                            "admin.materialZhinak",
                        ],
                        route_name: "",
                        childs_items: [{
                                name: "Материалдар",
                                font: "fa-comment-medical",
                                route_name: "admin.materials.index",
                                menu_active: ["admin.materials"],
                            },
                            {
                                name: "Жойылған материалдар",
                                font: "fa-comment-medical",
                                route_name: "admin.deletedMaterials.index",
                                menu_active: ["admin.deletedMaterials"],
                            },
                            {
                                name: "Материалдар Сыныбы",
                                font: "fa-comment-medical",
                                route_name: "admin.materialClasses.index",
                                menu_active: ["admin.materialClasses"],
                            },
                            {
                                name: "Материалдар Бағыты",
                                font: "fa-comment-medical",
                                route_name: "admin.materialDirections.index",
                                menu_active: ["admin.materialDirections"],
                            },
                            {
                                name: "Материалдар Пәні",
                                font: "fa-comment-medical",
                                route_name: "admin.materialSubjects.index",
                                menu_active: ["admin.materialSubjects"],
                            },
                            {
                                name: "Жинақ",
                                font: "fa-comment-medical",
                                route_name: "admin.materialZhinak.index",
                                menu_active: ["admin.materialZhinak"],
                            },

                        ],
                    },
                    {
                        name: "ҚМЖ",
                        font: "fa-comment-medical",
                        menu_active: [
                            "admin.qmgSubjects",
                            "admin.qmgBolim",
                        ],
                        route_name: "",
                        childs_items: [
                            {
                                name: "ҚМЖ Пәндер",
                                font: "fa-comment-medical",
                                route_name: "admin.qmgSubjects.index",
                                menu_active: ["admin.qmgSubjects"],
                            },
                            {
                                name: "ҚМЖ Бөлімдер",
                                font: "fa-comment-medical",
                                route_name: "admin.qmgBolim.index",
                                menu_active: ["admin.qmgBolim"],
                            },

                        ],
                    },
                    {
                        name: "Турнир",
                        font: "fa-comment-medical",
                        menu_active: [
                            "admin.turnir",
                            "admin.turnirAllQuestions",
                            "admin.turnirQuestions",
                            "admin.turnirUser",
                        ],
                        route_name: "",
                        childs_items: [
                            {
                                name: "Турнирлер",
                                font: "fa-comment-medical",
                                route_name: "admin.turnir.index",
                                menu_active: [
                                    "admin.turnir",
                                    "admin.turnirQuestions",
                                ],
                            },
                            {
                                name: "Сұрақтар",
                                font: "fa-comment-medical",
                                route_name: "admin.turnirAllQuestions.index",
                                menu_active: ["admin.turnirAllQuestions"],
                            },
                            {
                                name: "Қатысушылар",
                                font: "fa-comment-medical",
                                route_name: "admin.turnirUser.index",
                                menu_active: ["admin.turnirUser"],
                            },

                        ],
                    },
                    {
                        name: "Олимпиада",
                        font: "fa-comment-medical",
                        menu_active: [
                            "admin.olimpiadaBagyty",
                            "admin.olimpiadaTizim",
                            "admin.olimpiadaSuraktar",
                            "admin.olimpiadaOption",
                            "admin.olimpiadaAppeals",
                        ],
                        route_name: "",
                        childs_items: [
                            {
                                name: "Бағыт",
                                font: "fa-comment-medical",
                                route_name: "admin.olimpiadaBagyty.index",
                                menu_active: [
                                    "admin.olimpiadaBagyty",
                                    "admin.olimpiadaSuraktar",
                                    "admin.olimpiadaOption",
                                ],
                            },
                            {
                                name: "Қатысушылар",
                                font: "fa-comment-medical",
                                route_name: "admin.olimpiadaTizim.index",
                                menu_active: ["admin.olimpiadaTizim"],
                            },
                            {
                                name: "Аппеляция",
                                font: "fa-comment-medical",
                                route_name: "admin.olimpiadaAppeals.index",
                                menu_active: ["admin.olimpiadaAppeals"],
                            },

                        ],
                    },
                    {
                        name: "Шығу",
                        font: "fa-users",
                        route_name: "admin.logout",
                        menu_active: ["admin.logout"],
                    },


                    //                    {
                    //                        name: "Жеке кеңес",
                    //                        font: "fa-comment-medical",
                    //                        menu_active: [
                    //                            "admin.personalAdvice",
                    //                            "admin.personalAdviceOrders",
                    //                        ],
                    //                        route_name: "",
                    //                        childs_items: [{
                    //                                name: "Жеке кеңес",
                    //                                font: "fa-comment-medical",
                    //                                route_name: "admin.personalAdvice.index",
                    //                                menu_active: ["admin.personalAdvice"],
                    //                            },
                    //                            {
                    //                                name: "Жеке кеңес тапсырыстар",
                    //                                font: "fa-comment-medical",
                    //                                route_name: "admin.personalAdviceOrders.index",
                    //                                menu_active: ["admin.personalAdviceOrders"],
                    //                            },
                    //                        ],
                    //                    },
                ],
            }
        },
        mounted() {
            $('[data-widget="treeview"]').each(function() {
                adminlte.Treeview._jQueryInterface.call($(this), "init");
            });
        },
        computed: {
            currentRoute() {
                let currentRoute = route().current().split(".");
                currentRoute.pop();
                return currentRoute.join(".");
            },
        },

    }

</script>


<style scoped>

</style>
