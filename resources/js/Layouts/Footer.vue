<script setup>
import InstagramIcon from "@/Components/Icons/InstagramIcon.vue";
import LinkedinIcon from "@/Components/Icons/LinkedinIcon.vue";
import GithubIconFooter from "@/Components/Icons/GithubIconFooter.vue";
</script>

<template>
    <footer class="w-full mt-4">
        <div class="default-component">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="lg:flex lg:items-center">
                <ul class="flex space-x-6">
                    <li>
                        <a target="_blank" href="javascript:void(0)">
                            <InstagramIcon/>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="https://github.com/anastasiazavizion">
                            <GithubIconFooter/>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="https://www.linkedin.com/in/anastasia-zavizion-761129248">
                           <LinkedinIcon/>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4>{{$t('Contact Us')}}</h4>
                <ul class="footer-ul">
                    <li>
                        <a href="mailto:a.zavizion.a@gmail.com">{{$t('Email')}}</a>
                    </li>
                    <li>
                        <a href="tel:+380661865727">{{$t('Phone')}}</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4>{{$t('Information')}}</h4>
                <ul class="footer-ul">
                    <li>
                        <a href="javascript:void(0)">{{$t('About Us')}}</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">{{$t('Terms Conditions')}}</a>
                    </li>
                </ul>
            </div>
        </div>

        <p class="text-gray-300 text-sm mt-10 text-center">© {{$t('All rights reserved.')}}</p>
        </div>
    </footer>
</template>
