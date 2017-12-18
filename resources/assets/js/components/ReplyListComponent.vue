<template>
    <div>
        <div v-if="replyUrl">
            <div ref="editorElem"></div>
            <button class="btn btn-primary btn-sm" style="margin-top: 8px" @click="replyTopic">
                <i class="fa fa-reply"></i> 回复
            </button>
        </div>
        <hr>
        <div class="reply-list">
            <reply
                    v-for="reply in replyList"
                    :key="reply.id"
                    :reply="reply"
                    @removeReply="removeReply"
                    @addReply="addReply"
            >
            </reply>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            replyData: String,
            replyUrl: String,
            topicId: Number,
        },
        data() {
            return {
                replyList: null,
                replyEditor: null,
            }
        },
        mounted() {
            this.replyList = JSON.parse(this.replyData);
            if (this.replyUrl) {
                $(() => {
                    this.replyEditor = new window.wangEditor(this.$refs.editorElem);
                    this.replyEditor.customConfig.onchange = (html) => {
                        this.editorContent = html
                    };
                    this.replyEditor.create();
                });
            }
        },
        methods: {
            removeReply(replyId) {
                let index = this.replyList.findIndex(item => item.id === replyId);
                this.replyList.splice(index, 1);
            },
            addReply(reply) {
                this.replyList.unshift(reply);
            },
            replyTopic() {
                $.post(this.replyUrl, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    topic_id: this.topicId,
                    body: this.editorContent,
                }, data => {
                    if (data.err === 0) {
                        this.addReply(data.reply);
                        this.replyEditor.txt.clear();
                    }
                });
            }
        }
    }
</script>