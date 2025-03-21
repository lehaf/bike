<?php

const CATALOG_IBLOCK_ID = 26;

//разделы, участвующие в подаче объявлений
const TRANSPORT_SECTION_ID = 10682;
const PARTS_SECTION_ID = 10684;
const PRODUCTS_SECTION_ID = 10691;
const TIRES_SECTION_ID = 10692;
const SERVICES_SECTION_ID = 10693;
const GARAGES_SECTION_ID = 10683;
const RENT_SECTION_ID = 10710;

//список разделов в различных шаблонах (для catalog.section)
const SECTION_TYPE_1 = [10694, 10063, 7540, 9007, 10536, 10682]; //мототранспорт
const SECTION_TYPE_2 = [10684, 10685, 10686, 10687, 10688, 10689]; //остальные товары

const SECTION_TYPE_3 = [10683, 10693, 10692, 10710]; // услуги, гаражи, шины
const SECTION_TYPE_4 = [10691]; // товары


const SECTIONS_WITH_LOCATION = [10683, 10693, 10692, 10710];

const ALL_TRANSPORT_SECTION = 10682;
const ALL_PARTS_SECTION = 10684;
