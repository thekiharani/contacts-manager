<template>
    <div class="container">
        <router-view></router-view>
    </div>
</template>

<script>
    import Contacts from "./views/Contacts";
    import Home from "./views/Groups";

    export default {
        name: 'App',
        components: {Contacts, Home},
    }
</script>
