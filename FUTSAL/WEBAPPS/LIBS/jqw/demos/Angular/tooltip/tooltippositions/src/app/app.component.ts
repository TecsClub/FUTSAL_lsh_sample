import { Component, ViewChild, ViewEncapsulation } from '@angular/core';

import { jqxTooltipComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxtooltip';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styles: [`        
        jqxTooltip {
            margin: 8px;
        }

        jqxTooltip div {
            width: 110px;
            height: 162px;
        }
    `],
    encapsulation: ViewEncapsulation.None
})

export class AppComponent {

}