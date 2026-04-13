# AGENTS.md - import-product-link

## Zweck & Verantwortung

Das `import-product-link` Modul bietet **Product Link Import-Funktionalität**. Es ist ein **Tier 5 Modul** und erweitert `import-product`.

**Hauptverantwortung:**
- Product Link Import (Related, Upsell, Crosssell)
- Link Attribute Import
- Repository Pattern für Product Links
- Service Layer für Link-Verarbeitung
- Observer Pattern für Link-Hooks

## Architektur & Design Patterns

### Kern-Klassen
- **ProductLinkRepository**: Persistierung von Product Links
- **ProductLinkAttributeRepository**: Persistierung von Link Attributes
- **ProductLinkProcessor**: Service Layer
- **ProductLinkObserver**: Observer für Hooks

### Verwendete Patterns
- **Observer Pattern**: Für Link-Hooks
- **Repository Pattern**: Für Daten-Persistierung
- **Service Layer**: Für Business Logic

## Abhängigkeiten

### Externe Pakete
- **Keine**

### TechDivision Dependencies
- **import-product** ^26.2 - Product Importer

### Abhängig von diesem Modul (2 Reverse Dependencies)
1. **import-product-grouped** - Grouped Product Importer
2. **import-product-link-ee** - EE Link Extensions

## Wichtige Entry Points

### Repository Klassen
```php
// Product Link Repository
ProductLinkRepository::create($row): void
ProductLinkRepository::findByProductId($productId): array

// Product Link Attribute Repository
ProductLinkAttributeRepository::create($row): void
```

## Events & Extension Points

**Keine Events** - Tier 5 Importer-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 5 Modul**: Erweitert Product Importer
2. **Link-fokussiert**: Spezialisiert auf Product Links
3. **Observer Pattern**: Für Hooks
4. **Repository Pattern**: Für Persistierung
5. **2 Dependents**: Basis für Grouped Products und EE

## Bekannte Einschränkungen

- **Link-Only**: Keine anderen Features
- **Abhängig von Products**: Erfordert Products zu existieren

## Zusammenfassung

`import-product-link` ist ein **Tier 5 Modul**, das Product Link Import-Funktionalität bietet. Es erweitert den Product Importer mit spezialisierter Funktionalität für Product Links.

**Für Agenten:** Verstehe dieses Modul als **Product Link Importer** mit Observer und Repository Pattern.
