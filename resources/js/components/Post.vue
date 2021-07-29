<template>
  <el-card>
    <template #header>
      <h4 class="header">
        {{ post.title }}
      </h4>
    </template>
    <div>
      <div class="text">
        {{ post.description }}
      </div>
      <div class="icons-container">
          <el-popconfirm
            icon="el-icon-info"
            iconColor="red"
            title="Are you sure to delete this?"
            @confirm='deletePost()'
            >
            <template #reference>
              <i class="el-icon-delete"></i>
            </template>
          </el-popconfirm>
        <i class="el-icon-edit" v-on:click="$emit('openEditMode', post, index)"></i>
      </div>
    </div>
  </el-card>
  <el-alert v-if="errorOccured" type="error">
    {{ errorMessage }}
  </el-alert>
</template>

<script>
import ApiCaller from '../ApiCaller'
let apiCaller = new ApiCaller();

const Posts = {
  data() {
    return {
      errorOccured: false,
      errorMessage: ''
    }
  },
  props: ['post', 'index'],
  emits: ['deletePostInParent', 'openEditMode'],
  methods: {
    deletePost: async function() {
      await apiCaller.apiFetch('DELETE', `/api/post/${this.post.id}`)
        .then(result => {
          this.$emit('deletePostInParent', this.index);
        })
        .catch(err => {
          this.errorOccured = true;
          this.errorMessage = 'post not found';
        })
    }
  }
};
export default Posts
</script>

<style>
.el-icon-delete {
  color: #e34F4f;
  cursor: pointer;
  margin-right: 10px;
}

.el-icon-edit {
  color: #4cc679;
  cursor: pointer;
}

.icons-container {
  flex-direction: row;
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
}
</style>
