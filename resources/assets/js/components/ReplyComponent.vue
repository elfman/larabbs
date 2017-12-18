<template>
    <div v-if="!removed">
        <div class="media" :name="'reply'+replyId" :id="'reply'+replyId">
            <div class="avatar pull-left">
                <a :href="userUrl">
                    <img :src="avatar" :alt="username" width="48px" height="48px" class="media-object img-thumbnail">
                </a>
            </div>

            <div class="infos">
                <div class="media-heading">
                    <a :href="userUrl" :title="username">
                        {{ username }}
                    </a>
                    <span> •  </span>
                    <span class="meta" :title="createdAt">{{ createdAt }}</span>
                    <span class="meta pull-right" v-if="removeUrl">
                        <button ref="btn" type="submit" class="btn btn-default btn-xs pull-left" @click="removeReply">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </span>
                </div>
                <div class="reply-content">
                    <slot>-- Empty --</slot>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props: {
            replyId: Number,
            userUrl: String,
            userId: Number,
            username: String,
            avatar: String,
            createdAt: String,
            removeUrl: String,
        },
        data() {
            return {
                removed: false
            }
        },
        methods: {
            removeReply() {
                $.post(this.removeUrl, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE',
                }, data => {
                    if (data.err === 0) {
                        this.removed = true;
                    }
                });
            }
        },
    }
</script>