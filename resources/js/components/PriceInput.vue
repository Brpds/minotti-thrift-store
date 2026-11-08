<template>
  <input
    v-model="displayValue"
    @input="format"
    @blur="normalize"
    class=""
    inputmode="decimal"
  >
</template>

<script setup>
import { ref } from "vue";

const emit = defineEmits(["update:modelValue"]);
const displayValue = ref("");

function format(e) {
  let v = e.target.value;

  v = v.replace(/[^\d,]/g, "");     // números + vírgula
  v = v.replace(/(,.*),/g, "$1");   // apenas 1 vírgula

  // Formata real-time
  const parts = v.split(",");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  displayValue.value = parts.join(",");

  emitValue();
}

function normalize() {
  // garante 2 casas decimais ao sair do input
  let v = displayValue.value.replace(/\./g, "").replace(",", ".");
  const num = parseFloat(v || 0).toFixed(2);
  displayValue.value = Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL"
  }).format(num).replace("R$", "").trim();

  emitValue();
}

function emitValue() {
  let numeric = displayValue.value
    .replace(/\./g, "") // remove pontos
    .replace(",", "."); // troca vírgula por ponto

  emit("update:modelValue", parseFloat(numeric) || 0);
}
</script>