<script setup>
import { ref } from 'vue';
import { useStaffStore } from '@/stores';
import moment from 'moment'
import Table from '@/components/Table.vue'
import StaffModal from '@/components/StaffModal.vue'
let staffModal = ref();

const staff = useStaffStore();
await staff.index();
let staffs = ref(staff.staffs);
for (let index = 0; index < staffs.value.length; index++) {
  const element = staffs.value[index];

  delete element.email_verified_at;
  delete element.admin;

  element.created_at = moment(element.created_at).format('MMMM Do YYYY');
}

const headers = ref([
  {
    value: "ID",
    key: "id"
  },
  {
    value: "Name",
    key: "name"
  },
  {
    value: "Email",
    key: "email"
  },
  {
    value: "Username",
    key: "username"
  },
  {
    value: "Date Joined",
    key: "created_at"
  }
])

let form = ref({
  name: "",
  username: "",
  password: "",
  email: ""
})

let editable = ref(false);

const showModal = (target = null) => {
  if (target) {
    form.value.name = target.name;
    form.value.username = target.username;
    form.value.password = "";
    form.value.email = target.email;
    editable.value = true;
  } else {
    form.value = {
      name: "",
      username: "",
      password: "",
      email: ""
    }
    editable.value = false;
  }
  staffModal.value.show();
}
</script>

<template>
  <primary-button @click="showModal(null)" class="mb-2 sm:mb-4">Register Staff</primary-button>
  <StaffModal ref="staffModal" :form="form" :edit="editable"/>
  <Table :headers="headers" :data="staffs">
    <template v-slot:actions="{ item, index }">
        <primary-button @click="showModal(item)">Edit</primary-button> 
      </template>
  </Table>
</template>