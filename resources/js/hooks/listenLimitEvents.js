import {useToast} from "vue-toastification";
import {computed} from "vue";
import {useStore} from "vuex";

export default function listenLimitEvents(){

    const store = useStore();

    const user =  computed(()=>{
        return store.getters['auth/user']
    })

    window.Echo.private('payment_per_day_limit_channel_'+user.value.id)
        .listen('PaymentPerDayLimitEvent', (e) => {
            const toast = useToast();
            toast("You have exceeded your daily limit " + e.limit + "!");
        });

    window.Echo.private('payment_per_month_limit_channel_'+user.value.id)
        .listen('PaymentPerMonthLimitEvent', (e) => {
            const toast = useToast();
            toast("You have exceeded your month limit " + e.limit + "!");
        });
}
