<template src="./dashboard.html"></template>

<script>
    import PageHeader from '../../components/page_header/PageHeader';
    import MenuSidebar from '../../components/menu_sidebar/MenuSidebar';

    export default {
        components: {
            PageHeader,
            MenuSidebar,
        },

        mounted() {
            $('#app .content-wrapper').css('min-height', $(window).height());
        }
    }
</script>
