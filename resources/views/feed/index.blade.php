@extends('layouts.master')

@section('title', 'Feed')

@section('content')

    @include('common.nav-section')
    <hr class="color-9 my-0">

    <section class="font-1 py-4 h-full-non-fixed-nav">
        <div class="container">
            <div id="app">
                <div class="row">
                    <div class="col-lg-3 pb-4">
                        <div class="card border-color-9">
                            <div class="card-header background-oxford color-white p-3 border-color-oxford">
                                <i class="fa fa-rss pr-2"></i> Alumni Feeds
                            </div>
                            <div class="list-group list-group-flush alumni-feed-categories">
                                <a :class="feedType === 'all' && 'active'" class="list-group-item list-group-item-action hv-cursor-pointer" @click="getFeeds('all')"><i class="icon-A-Z mr-3"></i> All</a>
                                <a :class="feedType === 'event' && 'active'" class="list-group-item list-group-item-action hv-cursor-pointer" @click="getFeeds('event')"><i class="icon-Balloon mr-3"></i> Event</a>
                                <a :class="feedType === 'news' && 'active'" class="list-group-item list-group-item-action hv-cursor-pointer" @click="getFeeds('news')"><i class="icon-Newspaper-2 mr-3"></i> News</a>
                                <a :class="feedType === 'job' && 'active'" class="list-group-item list-group-item-action hv-cursor-pointer" @click="getFeeds('job')"><i class="icon-Management mr-3"></i> Job</a>
                                <a :class="feedType === 'donation' && 'active'" class="list-group-item list-group-item-action hv-cursor-pointer" @click="getFeeds('donation')"><i class="icon-Money-2 mr-3"></i> Donation</a>
                                <a :class="feedType === 'poll' && 'active'" class="list-group-item list-group-item-action hv-cursor-pointer" @click="getFeeds('poll')"><i class="icon-Bar-Chart3 mr-3"></i> Poll</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 pb-4">
                        <div class="text-center">
                            <div class="col" v-for="(feedEvent,index) in feedEvents">
                                <!-- Event start -->
                                <div v-if="feedEvent.relatable">
                                    <div v-if="feedEvent.activity_type === 'event_created' || feedEvent.activity_type ==='event_approved'">
                                        <div class="row align-items-center border-color-8 border py-4 mb-3">
                                            <div class="col-md-2 d-none d-md-block">
                                                <i class="fs-4 ml-3 color-4 icon-Balloon"></i>
                                            </div>
                                            <div class="col-12 col-md-8 text-left">
                                                <h4 class="fs-1 mb-2 color-oxford hv-cursor-pointer" @click="goto_route_event(feedEvent.relatable.id)">
                                                    @{{feedEvent.relatable.title}}
                                                </h4>
                                                <h6 class="color-3 fw-300">@{{moment(feedEvent.relatable.created_at,"YYYY-M-D H:i:s").format('D MMM, Y')}}</h6>
                                                <p class="color-2 fw-300 mt-3">@{{strip_html_tags(feedEvent.relatable.description.substring(0,50))}}...</p>
                                            </div>
                                            <div class="col text-left text-md-right mr-md-3 mt-3 mt-md-0">
                                                <button class="btn btn-outline-dark btn-block btn-xs hv-cursor-pointer" @click="goto_route_event(feedEvent.relatable.id)">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Event end -->

                                    <!-- news start -->

                                    <div v-if="feedEvent.activity_type === 'news_created'">
                                        <div class="row align-items-center border-color-8 border py-4 mb-3">
                                            <div class="col-md-2 d-none d-md-block">
                                                <i class="fs-4 ml-3 color-4 icon-Newspaper-2"></i>
                                            </div>
                                            <div class="col-12 col-md-8 text-left">
                                                <h4 class="fs-1 mb-2 color-oxford hv-cursor-pointer" @click="goto_route_news(feedEvent.relatable.id)">
                                                    @{{feedEvent.relatable.heading}}
                                                </h4>
                                                <h6 class="color-3 fw-300">@{{moment(feedEvent.relatable.created_at,"YYYY-M-D H:i:s").format('D MMM, Y')}}</h6>
                                                <p class="color-2 fw-300 mt-3">@{{strip_html_tags(feedEvent.relatable.description.substring(0,50))}}...</p>
                                            </div>
                                            <div class="col text-left text-md-right mr-md-3 mt-3 mt-md-0">
                                                <button class="btn btn-outline-dark btn-block btn-xs hv-cursor-pointer" @click="goto_route_news(feedEvent.relatable.id)">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- news end  -->

                                    <!-- donation start -->
                                    <div v-if="feedEvent.activity_type === 'donation_created' || feedEvent.activity_type ==='donation_approved'">
                                        <div class="row align-items-center border-color-8 border py-4 mb-3">
                                            <div class="col-md-2 d-none d-md-block">
                                                <i class="fs-4 ml-3 color-4 icon-Money-2"></i>
                                            </div>

                                            <div class="col-12 col-md-8 text-left">
                                                <h4 class="fs-1 mb-2 color-oxford hv-cursor-pointer" @click="goto_route_donation(feedEvent.relatable.id)">
                                                    @{{feedEvent.relatable.title}}
                                                </h4>
                                                <h6 class="color-3 fw-300">@{{moment(feedEvent.relatable.created_at,"YYYY-M-D H:i:s").format('D MMM, Y')}}</h6>
                                                <p class="color-2 fw-300 mt-3">@{{strip_html_tags(feedEvent.relatable.description.substring(0,50))}}...</p>
                                            </div>
                                            <div class="col text-left text-md-right mr-md-3 mt-3 mt-md-0">
                                                <button class="btn btn-outline-dark btn-block btn-xs hv-cursor-pointer" @click="goto_route_donation(feedEvent.relatable.id)">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- donation end -->

                                    <!-- Job start -->
                                    <div v-if="feedEvent.activity_type === 'job_created' || feedEvent.activity_type ==='job_approved'">
                                        <div class="row align-items-center border-color-8 border py-4 mb-3">
                                            <div class="col-md-2 d-none d-md-block">
                                                <i class="fs-4 ml-3 color-4 icon-Management"></i>
                                            </div>
                                            <div class="col-12 col-md-8 text-left">
                                                <h4 class="fs-1 mb-2 color-oxford hv-cursor-pointer" @click="goto_route_job(feedEvent.relatable.id)">
                                                    @{{feedEvent.relatable.job_title}}
                                                </h4>
                                                <h6 class="color-3 fw-300">@{{moment(feedEvent.relatable.created_at).format('D MMM, Y')}}</h6>
                                                <p class="color-2 fw-300 mt-3">@{{strip_html_tags(feedEvent.relatable.description.substring(0,50))}}...</p>
                                            </div>
                                            <div class="col text-left text-md-right mr-md-3 mt-3 mt-md-0">
                                                <button class="btn btn-outline-dark btn-block btn-xs hv-cursor-pointer" @click="goto_route_job(feedEvent.relatable.id)">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="feedEvent.activity_type === 'poll_created'">
                                        <div class="row align-items-center border-color-8 border py-5 mb-3">
                                            <div class="col-md-2 d-none d-md-block">
                                                <i class="fs-4 ml-3 color-4 icon-Bar-Chart3"></i>
                                            </div>
                                            <div class="col-12 col-md-8 text-left">
                                                <h4 class="fs-1 mb-2 color-oxford hv-cursor-pointer" @click="goto_route_poll(feedEvent.relatable.id)">
                                                    @{{feedEvent.relatable.title}}
                                                </h4>
                                                <h6 class="color-3 fw-300">@{{moment(feedEvent.relatable.created_at).format('D MMM, Y')}}</h6>
                                            </div>
                                            <div class="col text-left text-md-right mr-md-3 mt-3 mt-md-0">
                                                <button class="btn btn-outline-dark btn-block btn-xs hv-cursor-pointer" @click="goto_route_poll(feedEvent.relatable.id)">
                                                    Vote
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-xs hv-cursor-pointer my-4" @click="loadMoreFeeds('more')">
                                <i class="fa fa-angle-down fa-lg"></i> Load More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                feedEvents: [],
                feedType: "{{request('q', 'all')}}",
                moment: moment,
                pageCount: 0
            },
            mounted() {
                this.getFeeds(this.feedType, true);
            },

            methods: {
                getFeeds: function (feedTypeValue, forceLoad) {
                    if(!forceLoad) {
                        if (this.feedType !== feedTypeValue && this.feedType !== 'more') {
                            this.feedType = feedTypeValue;
                            this.pageCount = 0;
                        }
                        else {
                            return;
                        }
                    }

                    axios.post('/getFeeds', {
                        data: feedTypeValue
                    })
                        .then(function (response) {

                            this.feedEvents = [];
                            for (var i = 0; i < response.data.length; i++) {
                                this.feedEvents.push(response.data[i]);
                            }
                        }.bind(this))
                        .catch(function (error) {

                        });
                },
                loadMoreFeeds: function (feedTypeValue, feedType) {

                    this.pageCount = this.pageCount + 1;

                    axios.post('/getFeeds?pageCount=' + this.pageCount + '&type=' + this.feedType, {
                        data: feedTypeValue
                    }).then(function (response) {
                        for (var i = 0; i < response.data.length; i++) {
                            this.feedEvents.push(response.data[i]);
                        }
                    }.bind(this))
                    .catch(function (error) {

                    });

                },

                goto_route_donation: function (param1) {
                    route = "{{ route('donations.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                goto_route_event: function (param1) {
                    route = "{{ route('events.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                goto_route_news: function (param1) {
                    route = "{{ route('news.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                goto_route_job: function (param1) {
                    route = "{{ route('jobs.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },
                goto_route_poll: function (param1) {
                    route = "{{ route('poll.vote', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                strip_html_tags: function (str) {
                    if ((str === null) || (str === ''))
                        return false;
                    else {
                        str = str.toString();
                        return str.replace(/<[^>]*>/g, '');
                    }
                },
            },
        });
    </script>
    <script>
        $(function () {

            $('#slide-submenu').on('click', function () {
                $(this).closest('.list-group').fadeOut('slide', function () {
                    $('.mini-submenu').fadeIn();
                });

            });

            $('.mini-submenu').on('click', function () {
                $(this).next('.list-group').toggle('slide');
                $('.mini-submenu').hide();
            })
        })

    </script>

@endsection
