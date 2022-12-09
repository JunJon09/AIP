import {InfiniteLoading} from 'vue-infinite-loading'; // ライブラリの読み込み
Vue.component('infinite-loading', InfiniteLoading); // コンポーネント化

new Vue({
    el: '#view',
    data: {
        page: 0, // Offsetを指定するための変数
        imgs: [], // 格納
        path: [],
        items: [],
    },
    methods: { //どこでも呼べる関数を作成する
        fetchImgs($state) { 
            console.log("aaaf");
            let fetchedImgIdList = this.fetchedImgIdList(); // 
            const key = document.getElementById("key").textContent;
            axios.get('/getImg', {
                params: {
                    fetchedImgIdList: JSON.stringify(fetchedImgIdList),
                    page: this.page,
                    word:key
                }
            })
            .then(response => { //成功時
                console.log("呼ばれた")
                if (response.data.imgs.length) {
                    this.page++;
                    response.data.imgs.forEach (value => {
                        this.imgs.push(value);            
                        let a = new Object();
                        a.img = value;
                        this.items.push(a);
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

        fetchedImgIdList() {
            let fetchedImgIdList = [];
            for (let i = 0; i < this.imgs.length; i++) {
                fetchedImgIdList.push(this.imgs[i]);
            }
            return fetchedImgIdList;
        }
    }
});
