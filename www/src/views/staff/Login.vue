<script setup>
import { ref, reactive } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import InputLabel from '@/components/InputLabel.vue'
import TextInput from '@/components/TextInput.vue'
import PrimaryButton from '@/components/PrimaryButton.vue';
import { useAuthStore } from '@/stores';

const form = reactive({
  username: '',
  password: '',
  processing: false
});

const submit = async () => {
  form.processing = true;
  const authStore = useAuthStore();
  await authStore.login(form.username, form.password);

  form.processing = false;
}

</script>
<template>
  <GuestLayout>
    <form @submit.prevent="submit">
      <div>
        <InputLabel for="username" value="Username" />

        <TextInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required
          autocomplete="username" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
          autocomplete="current-password" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <PrimaryButton class="ml-4" :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
          Log in
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>