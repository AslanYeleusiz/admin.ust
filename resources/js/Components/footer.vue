<template>
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-{{ currentDate.getFullYear() }}
            <Link href="/">Ust.kz</Link>.</strong>
            All rights reserved.
         <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
    export default {
        components: {
            Link
        },
        data() {
            return {
                currentDate: new Date,
            }
        }
    }
</script>
