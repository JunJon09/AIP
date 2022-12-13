import { ref, onMounted } from "vue";

import {InfiniteLoading} from 'vue-infinite-loading'; // ライブラリの読み込み
Vue.component('infinite-loading', InfiniteLoading); // コンポーネント化

new Vue({
    el: '#tweet',
    data: {
        page: 0, // ツイートテーブルのOffsetを指定するための変数
        tweets: [], // ツイートを格納
    },
    methods: { //どこでも呼べる関数を作成する
        fetchTweets($state) { 
            let fetchedTweetIdList = this.fetchedTweetIdList(); // すでに取得したツイートのIDリストを取得

            axios.get('/fetch', {
                params: {
                    fetchedTweetIdList: JSON.stringify(fetchedTweetIdList),
                    page: this.page
                }
            })
            .then(response => { //成功時
                if (response.data.tweets.length) {
                    this.page++;
                    response.data.tweets.forEach (value => {
                        this.tweets.push(value);
                    });
                    $state.loaded();
                } else {
                    $state.complete();
                }
            })
            .catch(error => {
                console.log(error);
            })

        },

        fetchedTweetIdList() {
            let fetchedTweetIdList = [];
            for (let i = 0; i < this.tweets.length; i++) {
                fetchedTweetIdList.push(this.tweets[i].id);
            }
            return fetchedTweetIdList;
        }
    }
});