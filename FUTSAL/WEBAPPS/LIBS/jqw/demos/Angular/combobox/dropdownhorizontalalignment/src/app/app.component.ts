import { Component, ViewChild } from '@angular/core';

import { jqxComboBoxComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxcombobox';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html'
})

export class AppComponent {
    @ViewChild('myComboBox') myComboBox: jqxComboBoxComponent;

    source: any =
    {
        datatype: 'json',
        datafields: [
            { name: 'CompanyName' },
            { name: 'ContactName' }
        ],
        id: 'id',
        url: '../assets/customers.txt',
        async: false
    };

    dataAdapter: any = new jqx.dataAdapter(this.source);

    leftBtnOnChecked(): void {
        this.myComboBox.dropDownHorizontalAlignment('left');
    }

    count = 0; //Stops the Overwrite of the animation type on initialization
    rightBtnOnChecked(): void {
        if (this.count === 1)
            this.myComboBox.dropDownHorizontalAlignment('right');
        this.count = 1;
    }
}
