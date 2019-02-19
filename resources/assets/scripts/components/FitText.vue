<template>
    <h1>
        <slot></slot>
    </h1>
</template>

<script>
export default {
    props: {
        targetLineCount: {
            default: 1,
            type: Number
        },
        unit: {
            default: "em",
            type: String
        },
        min: {
            default: 0.5,
            type: Number
        },
        max: {
            default: 1,
            type: Number
        }
    },

    methods: {
        calculate() {
            let element = this.$el;
            // first make it an inline block and set the line height to a fixed pixel value
            element.style.display = "inline-block";
            element.style.lineHeight = "1px";

            let fontSize = this.max;
            let stepSize = this.unit === "px" ? 1 : 0.05;

            element.style.fontSize = fontSize + this.unit;
            while (
                element.offsetHeight > this.targetLineCount &&
                fontSize > this.min
            ) {
                fontSize -= stepSize;
                element.style.fontSize = fontSize + this.unit;
            }

            element.style.display = null;
            element.style.lineHeight = null;
        }
    },

    created () {
        window.addEventListener('resize', this.calculate);
    },

    mounted () {
        this.calculate();
    },

    destroyed () {
        window.removeEventListener('resize', this.handleScroll)
    }
};
</script>