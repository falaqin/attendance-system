<script setup>
import { ref } from 'vue';
import Modal from '@/components/Modal.vue'
import TextInput from '@/components/TextInput.vue';
import InputLabel from '@/components/InputLabel.vue';
import { useStaffStore } from '@/stores';

let staffStore = useStaffStore();
let modal = ref(false);
const show = () => modal.value = true;
const close = () => modal.value = false;

const props = defineProps({
  form: {
    default: {
      name: "",
      username: "",
      password: "",
      email: ""
    }
  },
  edit: {
    default: false
  }
})

const confirm = async () => {
  if (!props.edit) {
    await staffStore.create(props.form);
    close();
  }
}

defineExpose({
  show
});
</script>

<template>
  <Modal :show="modal" @close="close">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Create staff account
      </h2>

      <div class="mt-6">
        <div>
          <InputLabel for="name" value="Name" class="sr-only" />

          <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="Name" v-model="form.name" />
        </div>

        <div class="mt-4">
          <InputLabel for="username" value="Username" class="sr-only" />

          <TextInput id="username" type="text" class="mt-1 block w-full" placeholder="Username" v-model="form.username" />
        </div>

        <div class="mt-4">
          <InputLabel for="email" value="Email" class="sr-only" />

          <TextInput id="email" type="email" class="mt-1 block w-full" placeholder="Email" v-model="form.email" />
        </div>

        <div class="mt-4">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput id="password" ref="passwordInput" type="password" class="mt-1 block w-full" placeholder="Password" v-model="form.password" />
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <secondary-button @click="close"> Cancel </secondary-button>

        <primary-button class="ml-3" @click="confirm">
          Confirm
        </primary-button>
      </div>
    </div>
  </Modal>
</template>