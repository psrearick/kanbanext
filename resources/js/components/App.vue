<template>
    <div class="container grid grid--column">
        <nav>
            <router-link to="/">Home</router-link>
            <router-link to="/column/add">Add Column</router-link>
            <router-link to="/login">Log In</router-link>
            <router-link to="/register">Register</router-link>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
export default {}
</script>
