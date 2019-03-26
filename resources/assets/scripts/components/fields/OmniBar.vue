<template>
<on-click-outside :do="close">
    <div class="search-select" :class="{ 'is-active': isOpen }">
        <div class="d-flex">
            <button
                ref="button"
                @click="open"
                type="button"
                class="search-select-input"
            >
                <span v-if="value !== null">{{ toTitleCase(value) }}</span>
                <span v-else class="search-select-placeholder">Address, MLS, Area</span>
            </button>
            <span v-if="search !== ''" @click="clear()" class="btn btn-secondary pointer">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
        </div>
        <div ref="dropdown" v-show="isOpen" class="search-select-dropdown">
            <input
                ref="search"
                class="search-select-search"
                name="omni"
                v-model="search"
                @keydown.esc="close"
                autocomplete="off"
                id="omni-field"
            >
            <ul ref="options" v-show="filteredOptions.length > 0" class="search-select-options">
                <li
                    class="search-select-option"
                    v-for="option in filteredOptions"
                    :key="option.id"
                    @click="select(option.value)"
                >
                {{ toTitleCase(option.value) }}
                </li>
            </ul>
        <div
            v-show="filteredOptions.length === 0"
            class="search-select-empty">No results found for {{ search }}</div>
        </div>
    </div>
</on-click-outside>
</template>

<script>
import OnClickOutside from './OnClickOutside.vue';
export default {
    components: {
        OnClickOutside
    },
    props: ['value', 'options', 'filterFunction','fieldValue'],
    data() {
        return {
            isOpen: false,
            search: '',
        }
    },
    mounted(){
        if(this.fieldValue !== '') {
            this.select(this.fieldValue);
        }
    },
    computed : {
        filteredOptions() {
            return this.filterFunction(this.search, this.options)
        }
    },
    watch: {
        search: function (newValue, oldValue) {
            if (newValue.length > 2) {
                this.filter(newValue);
            }
        }
    },
    methods: {
        open() {
            this.isOpen = true
            this.$nextTick(() => {
                this.$refs.search.focus()
            })
        },
        close() {
            if (! this.isOpen) return
            this.isOpen = false
            this.$refs.button.focus();
        },
        clear() {
            this.search = '';
            this.$emit('input', '')
        },
        select(option) {
            this.search = option
            this.$emit('input', option)
            this.close()
        },
        filter(search) {
            this.$emit('input', search)
        },
        toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt){
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }
    }
}
</script>

<style scoped>
.search-select {
    position: relative;
    box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
}
.search-select-input {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    text-align: left;
    display: block;
    width: 100%;
    border-width: 1px;
    height: calc(3rem + 2px);
    padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    background-color: #fff;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid #ced4da;
}
.search-select-input:focus {
  outline: 0;
  -webkit-box-shadow: none;
  box-shadow: none;
}
.search-select-placeholder {
  color: #8795a1;
}
.search-select.is-active .search-select-input {
  -webkit-box-shadow: none;
  box-shadow: none;
}
.search-select-dropdown {
  position: absolute;
  right: 0;
  left: 0;
  background-color: #fff;
  padding: 0.5rem;
  -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
  z-index: 50;
  border: 1px solid #ddd;
}
.search-select-search {
  display: block;
  margin-bottom: 0.5rem;
  width: 100%;
  padding: 0.38rem 0.7rem;
  background-color: #fff;
  color: #2A2D2E;
  border-radius: 0;
  border: 1px solid #ddd;
}
.search-select-search:focus {
  outline: 0;
}
.search-select-options {
  list-style: none;
  padding: 0;
  position: relative;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  max-height: 14rem;
}
.search-select-option {
  padding: 0.5rem 0.75rem;
  color: #2A2D2E;
  cursor: pointer;
  border-radius: 0.25rem;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.search-select-option:hover {
  background-color: #432021;
  color: #fff;
}
.search-select-option.is-active,
.search-select-option.is-active:hover {
  background-color: #432021;
  color: #fff;
}
.search-select-empty {
  padding: 0.5rem 0.75rem;
  color: #b8c2cc;
}
</style>

