<script setup>
import { ref, onMounted } from 'vue';
import TextInput from '@/components/TextInput.vue';
import InputLabel from '@/components/InputLabel.vue';
import StaticBlock from '@/components/StaticBlock.vue';
import { useSettingStore } from '@/stores';

const setting = useSettingStore();

const getSettings = async () => {
    await setting.index();
}

getSettings()

const confirm = () => {
    setting.update();
}

const convertSnakeToNormal = (input) => {
    return input
        .split('_') // Split the string by underscores
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize the first letter of each word
        .join(' '); // Join the words with a space
}
</script>

<template>
    <StaticBlock v-if="setting.settings">
        <template v-for="config, index in setting.settings">
            <div :class="[index > 0 ? 'mt-4' : '']">
                <InputLabel :value="convertSnakeToNormal(config.key)" class="timepicker-ui-input" />

                <TextInput type="time" class="mt-1 block w-full" placeholder="Name" v-model="config.value" />
            </div>
        </template>
        <div class="mt-6 flex justify-end">
            <primary-button class="ml-3" @click="confirm">
                Save
            </primary-button>
        </div>
    </StaticBlock>
</template>