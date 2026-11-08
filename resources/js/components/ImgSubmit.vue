<template>
    <div class="space-y-4">
        <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
            
            <div @click="$refs.fileInput.click()" class="col-span-full md:col-span-2 md:col-start-2 aspect-square rounded-lg bg-surface-variant flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/30 text-outline cursor-pointer hover:bg-surface-container-high transition-colors">
                <img 
                    v-if="previewUrl" 
                    :src="previewUrl" 
                    class="w-full h-full object-cover rounded-lg"
                />
                
                <div v-else class="flex flex-col items-center">
                    <span class="material-symbols-outlined text-4xl mb-2">
                        add_a_photo
                    </span>
                </div>
                
            </div>
            <!-- Hidden input -->
            <input 
                type="file" 
                id="imageField"
                ref="fileInput" 
                class="hidden" 
                accept="image/*"
                @change="handleFileUpload"
            />
        </div>
        <span v-if="previewUrl" @click="clearImgPreview()" class="material-symbols-outlined block text-center cursor-pointer">
            delete
        </span>
        <label for="imageField" class="block font-headline font-bold text-on-surface text-center">Imagem</label>
    </div>
</template>

<script>
export default {
    props: ['modelValue'],
    emits: ['update:modelValue'],
    data(){
        return {
            previewUrl: '',
        }
    },
    methods:{

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            //sending the image to the parent via emit
            this.$emit('update:modelValue', file);
            
            this.previewUrl = URL.createObjectURL(file);
        },
        clearImgPreview(){
            this.previewUrl = '';
        },
    }
}
</script>

<style>

</style>