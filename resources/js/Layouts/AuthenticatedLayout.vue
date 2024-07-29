<template>
    <div class="h-screen bg-gray-50 flex w-full gap-4">
        <Navigation/>
        <main @drop.prevent="handleDrop" 
        @dragover.prevent="ondDragOver"
         @dragleave.prevent="onDragLeave" 
        :class="dragOver ? 'dropzone' : '' " 
        class="flex flex-col flex-1 px-4 overflow-hidden">

            <template v-if="dragOver" class="text-gray-500 text-center py-8 text-sm">
                Drop files here
            </template>

            <template v-else>
                 <div class="flex items-center justify-between w-full">
                    <SearchForm/>
                    <UserSettingsDropdown/>
                </div>

                <div class="flex-1 flex flex-col overflow-hidden">
                    <slot></slot>
                </div>
            </template>
        </main>
    </div>
</template>

<script setup>
import Navigation from "@/Components/app/Navigation.vue";
import SearchForm from "@/Components/app/SearchForm.vue";
import UserSettingsDropdown from "@/Components/app/UserSettingsDropdown.vue";
import {emitter, FILE_UPLOAD_STARTED} from "@/event-bus.js";
import { onMounted, ref } from "vue";

const dragOver = ref(false)

function ondDragOver(){
    dragOver.value = true
}

function onDragLeave(){
    dragOver.value = false
}

function handleDrop(ev){
    dragOver.value = false;
    const files = ev.dataTransfer.files
    console.log(files)
    if (!files.length){
        return 
    }
    uploadFiles(files)
}

function uploadFiles(files){
    console.log(files)
}

onMounted(()=>{
    emitter.on(FILE_UPLOAD_STARTED, uploadFiles)
})
</script>

<style scoped>
 .dropzone {
        width: 100%;
        height: 100%;
        color: #8d8d8d;
        border: 2px dashed gray;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
