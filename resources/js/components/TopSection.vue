<template>
    <div>
        <div class="back_photo">
            <h1 class="front_text">University Notices, Events, Complains all in one</h1>
        </div>
    </div>
</template>

<style scoped>
.front_text {
    -webkit-text-stroke: 1px #763cc1;
    padding-top: 200px;
    text-align: center;
    font-weight: 1000;
    color: #f5eaea;
    font-size: 40px;
}

@media (min-width: 320px) and (max-width: 767px) {
    .front_text {
        padding-top: 120px;
        text-align: center;
        font-weight: 900;
        color: #f5eaea;
        margin-left: 10px;
        margin-right: 10px;
    }
}

.back_photo {
    background-image: url("../../../assets/department.png");
    height: 530px;
}
</style>