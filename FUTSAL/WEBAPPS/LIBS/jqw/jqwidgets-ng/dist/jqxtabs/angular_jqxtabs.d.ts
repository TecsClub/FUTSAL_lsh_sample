/// <reference path="../jqwidgets.d.ts" />
import { EventEmitter, ElementRef, OnChanges, SimpleChanges } from '@angular/core';
export declare class jqxTabsComponent implements OnChanges {
    attrAnimationType: string;
    attrAutoHeight: boolean;
    attrCloseButtonSize: number;
    attrCollapsible: boolean;
    attrContentTransitionDuration: number;
    attrDisabled: boolean;
    attrEnabledHover: boolean;
    attrEnableScrollAnimation: boolean;
    attrEnableDropAnimation: boolean;
    attrInitTabContent: (tab?: number) => void;
    attrKeyboardNavigation: boolean;
    attrNext: any;
    attrPrevious: any;
    attrPosition: string;
    attrReorder: boolean;
    attrRtl: boolean;
    attrScrollAnimationDuration: number;
    attrSelectedItem: number;
    attrSelectionTracker: boolean;
    attrScrollable: boolean;
    attrScrollPosition: string;
    attrScrollStep: number;
    attrShowCloseButtons: boolean;
    attrToggleMode: string;
    attrTheme: string;
    attrWidth: string | number;
    attrHeight: string | number;
    autoCreate: boolean;
    properties: string[];
    host: any;
    elementRef: ElementRef;
    widgetObject: jqwidgets.jqxTabs;
    constructor(containerElement: ElementRef);
    ngOnInit(): void;
    ngOnChanges(changes: SimpleChanges): boolean;
    arraysEqual(attrValue: any, hostValue: any): boolean;
    manageAttributes(): any;
    moveClasses(parentEl: HTMLElement, childEl: HTMLElement): void;
    moveStyles(parentEl: HTMLElement, childEl: HTMLElement): void;
    createComponent(options?: any): void;
    createWidget(options?: any): void;
    __updateRect__(): void;
    setOptions(options: any): void;
    animationType(arg?: string): string;
    autoHeight(arg?: boolean): boolean;
    closeButtonSize(arg?: number): number;
    collapsible(arg?: boolean): boolean;
    contentTransitionDuration(arg?: number): number;
    disabled(arg?: boolean): boolean;
    enabledHover(arg?: boolean): boolean;
    enableScrollAnimation(arg?: boolean): boolean;
    enableDropAnimation(arg?: boolean): boolean;
    height(arg?: string | number): string | number;
    initTabContent(arg?: (tab?: number) => void): (tab?: number) => void;
    keyboardNavigation(arg?: boolean): boolean;
    next(arg?: any): any;
    previous(arg?: any): any;
    position(arg?: string): string;
    reorder(arg?: boolean): boolean;
    rtl(arg?: boolean): boolean;
    scrollAnimationDuration(arg?: number): number;
    selectedItem(arg?: number): number;
    selectionTracker(arg?: boolean): boolean;
    scrollable(arg?: boolean): boolean;
    scrollPosition(arg?: string): string;
    scrollStep(arg?: number): number;
    showCloseButtons(arg?: boolean): boolean;
    toggleMode(arg?: string): string;
    theme(arg?: string): string;
    width(arg?: string | number): string | number;
    addAt(index: number, title: string, content: string): void;
    addFirst(htmlElement1: any, htmlElement2: any): void;
    addLast(htmlElement1: any, htmlElement2?: any): void;
    collapse(): void;
    disable(): void;
    disableAt(index: number): void;
    destroy(): void;
    ensureVisible(index: number): void;
    enableAt(index: number): void;
    expand(): void;
    enable(): void;
    focus(): void;
    getTitleAt(index: number): string;
    getContentAt(index: number): any;
    getDisabledTabsCount(): any;
    hideCloseButtonAt(index: number): void;
    hideAllCloseButtons(): void;
    length(): number;
    removeAt(index: number): void;
    removeFirst(): void;
    removeLast(): void;
    select(index: number): void;
    setContentAt(index: number, htmlElement: string): void;
    setTitleAt(index: number, htmlElement: string): void;
    showCloseButtonAt(index: number): void;
    showAllCloseButtons(): void;
    val(value?: string): any;
    onAdd: EventEmitter<{}>;
    onCollapsed: EventEmitter<{}>;
    onDragStart: EventEmitter<{}>;
    onDragEnd: EventEmitter<{}>;
    onExpanded: EventEmitter<{}>;
    onRemoved: EventEmitter<{}>;
    onSelecting: EventEmitter<{}>;
    onSelected: EventEmitter<{}>;
    onTabclick: EventEmitter<{}>;
    onUnselecting: EventEmitter<{}>;
    onUnselected: EventEmitter<{}>;
    __wireEvents__(): void;
}
