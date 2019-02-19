<template>
    <ul>
        <li v-for="navitem in mainNav" v-bind:key="navitem.ID" class="nav-item" :class="{'dropdown': navitem.children.length > 0 }">
            <a :href="navitem.url" :class="'nav-link ' + navitem.classes">{{ navitem.title }}</a>
            <div class="dropdown-menu" v-if="navitem.children.length > 0" >
                <li v-for="(child, i) in navitem.children" v-bind:key="i">
                    <a :href="child.url" :class="'dropdown-item ' + child.classes">{{ child.title }}</a>
                </li>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {

        props: {
            mainNav: {}
        }

    }
</script>
<style>
    .main-navigation .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>