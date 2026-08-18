<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:booking-widget */
class __TwigTemplate_7fa0d2496cfa2780c1c0490a18c5f0fd extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--booking-widget"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:booking-widget"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:booking-widget"));
        yield "<div class=\"relative\"
  x-data=\"{
    active: \x27studio\x27,
    pickerOpen: false,
    capacityIndex: { desk: 0, meeting: 3, studio: 0 },
    tabs: [ { id: \x27desk\x27, label: \x27Desk\x27 }, { id: \x27meeting\x27, label: \x27Meeting Room\x27 }, { id: \x27studio\x27, label: \x27Studio\x27 } ],
    capacityOptions: {
      desk: [ { label: \x271 journalist\x27, value: \x271 journalist\x27 } ],
      meeting: [
        { label: \x271 person\x27, value: \x271 person\x27 },
        { label: \x272 people\x27, value: \x272 people\x27 },
        { label: \x273 people\x27, value: \x273 people\x27 },
        { label: \x275 people\x27, value: \x275 people\x27 },
        { label: \x276 people\x27, value: \x276 people\x27 },
      ],
      studio: [
        { label: \x271 journalist only\x27, value: \x271 journalist · no guests\x27 },
        { label: \x271 journalist + 1 guest\x27, value: \x271 journalist · 1 guest\x27 },
        { label: \x271 journalist + 2 guests\x27, value: \x271 journalist · 2 guests\x27 },
      ],
    },
    get options() { return this.capacityOptions[this.active]; },
    get selected() { return this.options[this.capacityIndex[this.active] ?? 0]; },
    get isDeskFixed() { return this.active === \x27desk\x27; },
    get pricingText() {
      return this.active === \x27studio\x27 ? \x27Studio · 400 MAD / hr\x27 : (this.active === \x27meeting\x27 ? \x27Meeting Room · Free for journalists\x27 : \x27Desk · Free for journalists\x27);
    },
    selectTab(id) { this.active = id; this.pickerOpen = false; },
  }\"
>
  <div class=\"absolute -inset-4 bg-gradient-to-br from-[#9F5434]/10 via-transparent to-[#9F5434]/5 rounded-[28px] blur-2xl\"></div>
  <div class=\"relative bg-white rounded-3xl shadow-[0_30px_80px_-30px_rgba(15,110,86,0.28),0_4px_12px_-4px_rgba(11,15,14,0.06)] border border-neutral-900/[0.06] overflow-visible\">

    <div class=\"px-7 pt-6 pb-5 border-b border-neutral-100\">
      <div class=\"flex items-center justify-between mb-1\">
        <div class=\"text-[12px] uppercase tracking-[0.14em] text-[#0F6E56] font-semibold\">Booking</div>
        <div class=\"flex items-center gap-1.5 text-[11px] text-neutral-500\">
          <span class=\"w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse\"></span>
          Live availability
        </div>
      </div>
      <div class=\"text-[20px] tracking-tight text-neutral-900 font-semibold\">Reserve your space</div>
    </div>

    <div class=\"px-7 pt-5\">
      <div class=\"grid grid-cols-3 gap-2 p-1 bg-neutral-100 rounded-xl\">
        <template x-for=\"t in tabs\" :key=\"t.id\">
          <button
            type=\"button\"
            x-on:click=\"selectTab(t.id)\"
            :class=\"active === t.id ? \x27bg-white shadow-sm text-neutral-900 font-semibold\x27 : \x27text-neutral-500 hover:text-neutral-800 font-medium\x27\"
            class=\"relative px-3 py-2.5 rounded-lg text-[13px] transition-all\"
            x-text=\"t.label\"
          ></button>
        </template>
      </div>
    </div>

    <div class=\"px-7 py-6 grid grid-cols-2 gap-3\">
      <div class=\"text-left border border-neutral-200 rounded-xl px-4 py-3\">
        <div class=\"flex items-center gap-2 text-[11px] uppercase tracking-wide text-neutral-500 mb-1\">
          ";
        // line 62
        yield from $this->load("cfc_media_hub:icon", 62)->unwrap()->yield(CoreExtension::toArray(["name" => "calendar", "size" => "w-4 h-4 text-[#9F5434]"]));
        // line 63
        yield "          Date
        </div>
        <div class=\"text-[14px] text-neutral-900 font-medium\">Tue, 28 Apr</div>
      </div>
      <div class=\"text-left border border-neutral-200 rounded-xl px-4 py-3\">
        <div class=\"flex items-center gap-2 text-[11px] uppercase tracking-wide text-neutral-500 mb-1\">
          ";
        // line 69
        yield from $this->load("cfc_media_hub:icon", 69)->unwrap()->yield(CoreExtension::toArray(["name" => "clock", "size" => "w-4 h-4 text-[#9F5434]"]));
        // line 70
        yield "          Time slot
        </div>
        <div class=\"text-[14px] text-neutral-900 font-medium\">10:00 – 12:00</div>
      </div>

      <div class=\"col-span-2 relative\" x-on:click.outside=\"pickerOpen = false\">
        <button
          type=\"button\"
          x-on:click=\"if (!isDeskFixed) pickerOpen = !pickerOpen\"
          :class=\"isDeskFixed ? \x27border-neutral-200 cursor-default\x27 : (pickerOpen ? \x27border-[#9F5434]/50 bg-[#9F5434]/5\x27 : \x27border-neutral-200 hover:border-[#9F5434]/40 hover:bg-[#9F5434]/5\x27)\"
          class=\"w-full text-left border rounded-xl px-4 py-3 transition-colors\"
        >
          <div class=\"flex items-center gap-2 text-[11px] uppercase tracking-wide text-neutral-500 mb-1\">
            ";
        // line 83
        yield from $this->load("cfc_media_hub:icon", 83)->unwrap()->yield(CoreExtension::toArray(["name" => "users", "size" => "w-4 h-4 text-[#9F5434]"]));
        // line 84
        yield "            <span x-text=\"active === \x27desk\x27 ? \x27Journalist\x27 : (active === \x27meeting\x27 ? \x27Attendees\x27 : \x27Capacity\x27)\"></span>
          </div>
          <div class=\"flex items-center justify-between\">
            <span class=\"text-[14px] text-neutral-900 font-medium\" x-text=\"selected.value\"></span>
            <span x-show=\"!isDeskFixed\" :class=\"pickerOpen ? \x27rotate-180\x27 : \x27\x27\" class=\"transition-transform\">
              ";
        // line 89
        yield from $this->load("cfc_media_hub:icon", 89)->unwrap()->yield(CoreExtension::toArray(["name" => "chevron-down", "size" => "w-4 h-4 text-neutral-400"]));
        // line 90
        yield "            </span>
          </div>
          <div x-show=\"active === \x27studio\x27\" class=\"mt-1 text-[11px] text-[#9F5434] font-medium\">
            Max: 1 journalist + 2 guests
          </div>
        </button>

        <div x-show=\"pickerOpen && !isDeskFixed\" x-cloak class=\"absolute top-full left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-xl shadow-[0_12px_40px_-12px_rgba(0,0,0,0.15)] z-50 overflow-hidden\">
          <template x-for=\"(opt, i) in options\" :key=\"opt.value\">
            <button
              type=\"button\"
              x-on:click=\"capacityIndex[active] = i; pickerOpen = false;\"
              :class=\"i === capacityIndex[active] ? \x27bg-[#9F5434]/8 text-[#9F5434] font-semibold\x27 : \x27text-neutral-700 hover:bg-neutral-50 font-normal\x27\"
              class=\"w-full text-left px-4 py-3 text-[14px] transition-colors flex items-center justify-between border-b border-neutral-100 last:border-0\"
            >
              <span x-text=\"opt.label\"></span>
              <span x-show=\"i === capacityIndex[active]\" class=\"w-2 h-2 rounded-full bg-[#9F5434]\"></span>
            </button>
          </template>
        </div>
      </div>
    </div>

    <div class=\"px-7 pb-7\">
      <a
        :href=\"\x27";
        // line 115
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["booking_base_url"] ?? null), "html", null, true);
        yield "?space=\x27 + active\"
        class=\"btn-premium w-full bg-[#9F5434] hover:bg-[#8A4A2E] text-white py-4 rounded-2xl flex items-center justify-center gap-2 group\"
      >
        <span class=\"text-[14px] font-semibold\">Check availability</span>
        ";
        // line 119
        yield from $this->load("cfc_media_hub:icon", 119)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4", "class" => "group-hover:translate-x-0.5 transition-transform"]));
        // line 120
        yield "      </a>
    </div>

    <div class=\"px-7 py-3 bg-[#9F5434]/5 border-t border-[#9F5434]/15 text-[12px]\">
      <span class=\"text-neutral-700\" x-text=\"pricingText\"></span>
    </div>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["booking_base_url"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:booking-widget";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  184 => 120,  182 => 119,  175 => 115,  148 => 90,  146 => 89,  139 => 84,  137 => 83,  122 => 70,  120 => 69,  112 => 63,  110 => 62,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:booking-widget", "themes/custom/cfc_media_hub/components/booking-widget/booking-widget.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 62];
        static $filters = ["escape" => 115];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [0 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
