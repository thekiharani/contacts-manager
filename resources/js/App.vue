<template>
    <div class="container">
        <h1>App Component</h1>

        <router-view></router-view>
    </div>
</template>

<script>
    import Contacts from "./components/Contacts";
    import Home from "./components/Home";

    export default {
        name: 'App',
        components: {Contacts, Home},
    }
</script>
