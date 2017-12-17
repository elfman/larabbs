<template>
    <button class="btn btn-default btn-xs" @click="removeTopic">
        <i class="glyphicon glyphicon-trash"></i> 删除
    </button>
</template>

<script>
    export default {
        props: {
            url: String,
            redirectTo: String,
        },
        methods: {
            removeTopic() {
                $.post(this.url, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE',
                }, (data) => {
                    if (data.err === 0) {
                        window.location.replace(this.redirectTo);
                    }
                });
            }
        }
    }
</script>