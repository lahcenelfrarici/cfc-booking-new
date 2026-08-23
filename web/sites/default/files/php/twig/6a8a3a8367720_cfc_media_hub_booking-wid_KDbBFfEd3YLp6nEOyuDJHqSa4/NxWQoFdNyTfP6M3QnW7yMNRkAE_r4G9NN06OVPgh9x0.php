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
  data-slots=\x27";
        // line 2
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["next_slots_json"] ?? null));
        yield "\x27
  x-data=\"{
    active: \x27studio\x27,
    slots: {},
    tabs: [ { id: \x27desk\x27, label: \x27Desk\x27 }, { id: \x27meeting\x27, label: \x27Meeting Room\x27 }, { id: \x27studio\x27, label: \x27Studio\x27 } ],
    get slot() { return this.slots[this.active] || null; },
    get href() { return this.slot ? this.slot.book_url : \x27";
        // line 8
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["booking_base_url"] ?? null), "html", null, true);
        yield "?space=\x27 + this.active; },
    selectTab(id) { this.active = id; },
  }\"
  x-init=\"slots = JSON.parse(\$el.dataset.slots);\"
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

    <div class=\"px-7 py-6\">
      <template x-if=\"slot\">
        <div class=\"grid grid-cols-2 gap-3\">
          <div class=\"text-left border border-neutral-200 rounded-xl px-4 py-3\">
            <div class=\"flex items-center gap-2 text-[11px] uppercase tracking-wide text-neutral-500 mb-1\">
              ";
        // line 46
        yield from $this->load("cfc_media_hub:icon", 46)->unwrap()->yield(CoreExtension::toArray(["name" => "calendar", "size" => "w-4 h-4 text-[#9F5434]"]));
        // line 47
        yield "              Date
            </div>
            <div class=\"text-[14px] text-neutral-900 font-medium\" x-text=\"slot.day_label\"></div>
          </div>
          <div class=\"text-left border border-neutral-200 rounded-xl px-4 py-3\">
            <div class=\"flex items-center gap-2 text-[11px] uppercase tracking-wide text-neutral-500 mb-1\">
              ";
        // line 53
        yield from $this->load("cfc_media_hub:icon", 53)->unwrap()->yield(CoreExtension::toArray(["name" => "clock", "size" => "w-4 h-4 text-[#9F5434]"]));
        // line 54
        yield "              Time slot
            </div>
            <div class=\"text-[14px] text-neutral-900 font-medium\" x-text=\"slot.time_range\"></div>
          </div>
        </div>
      </template>
      <template x-if=\"!slot\">
        <p class=\"text-[13px] text-neutral-500 bg-neutral-50 border border-neutral-100 rounded-xl px-4 py-3\">
          No availability in the next two weeks — check the full calendar.
        </p>
      </template>
    </div>

    <div class=\"px-7 pb-7\">
      <a
        :href=\"href\"
        class=\"btn-premium w-full bg-[#9F5434] hover:bg-[#8A4A2E] text-white py-4 rounded-2xl flex items-center justify-center gap-2 group\"
      >
        <span class=\"text-[14px] font-semibold\" x-text=\"slot ? \x27Check availability\x27 : \x27View calendar\x27\"></span>
        ";
        // line 73
        yield from $this->load("cfc_media_hub:icon", 73)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4", "class" => "group-hover:translate-x-0.5 transition-transform"]));
        // line 74
        yield "      </a>
    </div>

    <template x-if=\"slot\">
      <div class=\"px-7 py-3 bg-[#9F5434]/5 border-t border-[#9F5434]/15 text-[12px]\">
        <span class=\"text-neutral-700\" x-text=\"slot.title + \x27 · \x27 + slot.price_label\"></span>
      </div>
    </template>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["next_slots_json", "booking_base_url"]);        yield from [];
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
        return array (  135 => 74,  133 => 73,  112 => 54,  110 => 53,  102 => 47,  100 => 46,  59 => 8,  50 => 2,  44 => 1,);
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
        static $tags = ["include" => 46];
        static $filters = ["raw" => 2, "escape" => 8];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [0 => "raw", 1 => "escape"],
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
