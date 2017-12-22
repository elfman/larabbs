<template>
    <div v-if="!removed">
        <div class="media" :name="'reply'+reply.number" :id="'reply'+reply.number">
            <div class="avatar pull-left">
                <a :href="reply.user_url">
                    <img :src="reply.avatar" :alt="reply.username" width="48px" height="48px" class="media-object img-thumbnail">
                </a>
            </div>

            <div class="infos">
                <div class="media-heading">
                    <a :href="reply.user_url" :title="reply.username" style="color: #337ab7;">
                        {{ reply.username }}
                    </a>
                    <span> • </span>
                    <span v-if="reply.to_reply">
                        <span> 回复 </span>
                        <a :href="reply.to_user_url" style="color: #337ab7;">{{ reply.to_username }}</a>
                        <a class="meta" :href="'#reply' + reply.to_number">{{ reply.to_number }}楼</a>
                    </span>
                    <span class="meta" :title="reply.created_at">{{ reply.created_at }}</span>
                    <span class="meta pull-right" style="margin-left: 7px;"> {{ reply.number }}楼 </span>
                    <span class="meta pull-right">
                        <button type="submit" class="btn btn-default btn-xs pull-left" @click="showEditor" v-if="reply.can_reply && !replying">
                            <i class="glyphicon glyphicon-share"></i> 回复
                        </button>
                        <button type="submit" class="btn btn-default btn-xs pull-left" @click="dismissEditor" v-if="replying">
                            <i class="fa fa-close"></i> 关闭
                        </button>
                        <button type="submit" class="btn btn-default btn-xs" @click="removeReply" v-if="reply.remove_url" style="margin-left: 4px;">
                            <i class="glyphicon glyphicon-trash"></i> 删除
                        </button>
                    </span>
                </div>
                <div class="reply-content" v-html="reply.content">
                </div>
            </div>
        </div>
        <div style="display: none; margin-top: 8px;" :style="{ display: replying ? 'block' : 'none' }">
            <div ref="editorElem"></div>
            <button class="btn btn-primary btn-sm" style="margin-top: 8px" @click="submitReply">
                <i class="fa fa-reply"></i> 回复
            </button>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props: {
            reply: Object,
        },
        data() {
            return {
                removed: false,
                editorContent: null,
                replying: false,
                editorCreated: false,
                replyEditor: null,
            }
        },
        methods: {
            removeReply() {
                $.post(this.reply.remove_url, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE',
                }, data => {
                    if (data.err === 0) {
                        this.$emit('removeReply', this.reply.id)
                    }
                });
            },
            showEditor() {
                this.replying = true;
                if (!this.editorCreated) {
                    this.replyEditor = new wangEditor(this.$refs.editorElem);
                    this.replyEditor.customConfig.onchange = (html) => {
                        this.editorContent = html
                    };
                    this.replyEditor.create();
                    this.editorCreated = true;
                }
            },
            dismissEditor() {
                this.replying = false;
            },
            submitReply() {
                $.post(this.reply.reply_url, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    topic_id: this.reply.topic_id,
                    body: this.editorContent,
                    to_reply: this.reply.id,
                }, data => {
                    if (data.err === 0) {
                        this.$emit('addReply', data.reply);
                        this.dismissEditor();
                        this.replyEditor.text.clear();
                    }
                });
            }
        },
    }
</script>