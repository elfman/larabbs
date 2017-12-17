<template>
    <button ref="btn" type="submit" class="btn btn-default btn-xs pull-left" @click="removeReply">
        <i class="glyphicon glyphicon-trash"></i>
    </button>
</template>

<script>
    export default {
        props: {
            url: String,
            replyId: Number,
        },
        methods: {
            removeReply() {
                $.post(this.url, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE',
                }, data => {
                    if (data.err === 0) {
                        $(`#reply${this.replyId}`).remove();
                    }
                });
            }
        }
    }
</script>