window.onload = function () {
            $(".scw").each(function () {
                // 개별적으로 Wheel 이벤트 적용
                //each: 주어진 배열을 각 배열마다 함수를 한번씩 실행시키는 매서드이다. 뜻: 각각의
                $(this).on("mousewheel DOMMouseScroll", function (e) {
                    //.on: 함수 호출
                    //mousewheel - 익스플로러, 오페라 등의 브라우저의 이벤트
                    //DOMMouseScroll - 파이어폭스의 이벤트
                    //(파이어 폭스는 mousewheel 이라는 이벤트가 없기 때문에 mousewheel 과 DOMMouseScroll 이벤트 두개를 동시에 걸어주는 메서드인 .on() 를 사용해야 합니다.)
                    //e는 매개변수: 몇 개의 변수 사이에 함수관계를 정하기 위해서 사용되는 또 다른 하나의 변수
                    e.preventDefault();
                    var E = e.originalEvent;
                    console.log(E);
                    delta = 0;
                    //delta 초기값: 0;
                    if (E.wheelDelta) {
                        //만약 wheelDelta(익스플로러)라면
                        delta = E.wheelDelta / 120;
                        //delta 값이 E.wheelDelta(익스플로러)에서 나누기 120을 한것과 동일.
                        //wheelDelta = 120
                        // delta = 120/120 = 1
                        if (window.opera) delta = -delta;
                    } else if (E.detail) delta = -E.detail / 3;
                    //아니라면 detail(파이어폭스)라면 delta 값은 -E.detail(파이어폭스)에서 나누기 3한 것과 동일.
                    //detail = -3
                    //delta = -(-3)/3 =1 
                    
                    var moveTop = null;
                    // 마우스휠을 위에서 아래로
                    //moveTop의 값을 비워놓음.
                    if (delta < 0) {
                        //만약 delta의 값이 0보다 작다면. 즉, -1이라면.
                        if ($(this).next() != undefined) {
                            //this(.box)의 다음 오브젝트가 있지 않다(undefined) 가 아니라면(!=)
                            //this(.box)의 다음 오브젝트가 있다면.
                            moveTop = $(this).next().offset().top;
                            //moveTop = 이것의 다음의 것의(.next) 높이를(.top) 차감하다(.offset)
                        }
                    // 마우스휠을 아래에서 위로
                    } else {
                        if ($(this).prev() != undefined) {
                            //this(.box)의 전 오브젝트가 있지 않다(undefined) 가 아니라면(!=).
                            //this(.box)의 전 오브젝트가 있다면.
                            moveTop = $(this).prev().offset().top;
                            //moveTop = 이것의 이전의 것의(.next) 높이를(.top) 차감하다(.offset)
                        }
                    }
                    // 화면 이동 0.8초(800)
                    $("html,body").stop().animate({
                        //html,body(제어대상) 애니메이션
                        scrollTop: moveTop + 'px'
                    }, {
                        duration: 800, complete: function () {
                            //애니메이션이 걸리는 시간 800, 
                        }
                    });
                });
            });
        }