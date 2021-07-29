<template>
  <div v-for="(post, index) in posts">
    <el-row justify='center'>
      <el-col :md={span:12}>
        <Post :post=post :index=index @deletePostInParent='deletePost' @openEditMode='openEditMode'></Post>
      </el-col>
    </el-row>
  </div>
  <el-drawer
    title="Edit post"
    v-model="editDrawer"
    direction="btt"
    >
    <el-input
      type="textarea"
      v-model="post.title"
      maxlength="255"
      show-word-limit
      >
    </el-input>
    <el-input
      type="textarea"
      v-model="post.description"
      maxlength="255"
      show-word-limit
      >
    </el-input>
    <el-button type="success" v-on:click="updatePost()">Confirm</el-button>
  <el-alert v-if="errorOccured" type="error">
    {{ errorMessage }}
  </el-alert>
  </el-drawer>
</template>

<script>
import Post from './Post.vue';
import ApiCaller from '../ApiCaller'
let apiCaller = new ApiCaller();
const default_layout = "default";


const Posts = {
  computed: {},
  data() {
      return {
        editDrawer: false,
        post: {},
        postIndex: 0,
        errorOccured: false,
        errorMessage: '',
        posts: null
      }
  },
  async mounted() {
    await this.fetchPosts();
  },
  methods: {
    async fetchPosts() {
      await apiCaller.apiFetch('GET', '/api/post')
        .then(res => {
          this.posts = res;
      })
    },

    deletePost(index) {
      this.posts.splice(index, 1);
    },

    openEditMode(post, index) {
      console.log(post);
      this.post = post;
      this.postIndex = index;
      this.editDrawer = true;
    },

    updatePostDescription(description) {
      this.post.description = description;
    },

    updatePostTitle(title) {
      this.post.title = title;
    },

    async updatePost() {
      await apiCaller.apiFetch('PUT', `/api/post/${this.post.id}`, false, {title: this.post.title, description: this.post.description})
        .then(res => {
          this.editDrawer = false;
        })
        .catch(err => {
          this.errorOccured = true;
          this.errorMessage = 'field cant be empty';
        })
    }

  },
  components: {
    'Post': Post
  }
};
export default Posts
</script>

<style>
.el-row {
  margin-bottom: 20px;
}
</style>
