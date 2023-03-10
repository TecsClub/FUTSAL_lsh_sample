import { Component, ViewChild } from '@angular/core';

import { jqxDropDownListComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdropdownlist';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html'
})

export class AppComponent {
    @ViewChild('myDropDownList') myDropDownList: jqxDropDownListComponent;

    flag: boolean = false;

    source: any = {
        datatype: 'json',
        datafields: [
            { name: 'CompanyName' },
            { name: 'ContactName' }
        ],
        id: 'id',
        url: '../assets/customers.txt',
    };

    dataAdapter: any = new jqx.dataAdapter(this.source);
    
    bottomAlignBtnOnChecked(): void {
        this.myDropDownList.dropDownVerticalAlignment('bottom');
    };

    // stops initial overwrite
    topAlignBtnOnChecked(): void {
        if(this.flag)
            this.myDropDownList.dropDownVerticalAlignment('top');
        this.flag = true;
    };
}

