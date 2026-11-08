<template>
  <div class="mb-4">
    <label v-if="label" class="label-patina">{{ label }}</label>

    <multiselect
      v-model="selected"
      :options="options"
      :loading="isLoading"
      :searchable="true"
      :internal-search="false"
      :clear-on-select="true"
      :close-on-select="true"
      :options-limit="300"
      :custom-label="option => option?.nome ?? ''"
      label="nome"
      track-by="id"
      placeholder="Buscar"
      @search-change="onSearchChange"
    />

    <!-- Optional for debug -->
    <!-- <pre>{{ selected }}</pre> -->
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css';
import axios from "axios";
import debounce from "lodash/debounce";

export default {
  components: { Multiselect },
  props: {
    label: String,
    apiUrl: { type: String, required: true },
    modelValue: { type: [Object, Number, String, Array], default: null },
  },
  emits: ["update:modelValue"],
  data() {
    return {
      //selected: this.modelValue,
      selected: null,
      options: [],
      isLoading: false,
    };
  },
  watch: {
    selected(newVal) {
      this.$emit("update:modelValue", newVal);
    },
  },
  methods: {
    async fetchOptions(query = "") {
      this.isLoading = true;
      try {
        
        const { data } = await axios.get('api/v1/' + this.apiUrl, {
          params: { query },
        });
        //console.log("opts: ", data)
        this.options = data;
      } finally {
        this.isLoading = false;
      }
    },
    //função que limita a query a ms depois que 
    onSearchChange: debounce(function (query) {
      this.fetchOptions(query);
    }, 300),
  },
  mounted() {
    //console.log("Mounted component")
    this.fetchOptions(); // load initial set
  },
};
</script>

<style scoped>

</style>