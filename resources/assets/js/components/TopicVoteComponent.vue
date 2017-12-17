<template>
    <div class="topic-vote" @click="toggleVote">
        <i class="glyphicon glyphicon-thumbs-up" :style="{ color: (_voted ? 'red' : 'inherit')}"></i> {{ _voteCount }}
    </div>
</template>

<script>
    export default {
        props: {
            url: String,
            voteCount: Number,
            voted: Boolean,
            disabled: Boolean,
        },
        data() {
            return {
                _voteCount: this.voteCount,
                _voted: this.voted,
            };
        },
        created() {
            this._voteCount = this.voteCount;
            this._voted = this.voted;
        },
        methods: {
            toggleVote() {
                if (this.disabled) {
                    return;
                }
                $.post(this.url, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    action: this._voted ? 'unvote' : 'upvote',
                }, (data) => {
                    if (data.err === 0) {
                        if (this._voted) {
                            this._voted = false;
                            this._voteCount--;
                        } else {
                            this._voted = true;
                            this._voteCount++;
                        }
                        this.$forceUpdate();
                    }
                })
            },
        }
    }
</script>

<style>
    .topic-vote {
        margin-left: 8px;
        cursor: pointer;
    }
</style>